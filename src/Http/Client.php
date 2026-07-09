<?php

declare(strict_types=1);

namespace Gonon\Core\Http;

use Gonon\Core\Contracts\HttpClientInterface;
use Gonon\Core\Contracts\MiddlewareInterface;
use Gonon\Core\Contracts\RequestInterface;
use Gonon\Core\Contracts\ResponseInterface;
use Gonon\Core\Contracts\RetryStrategyInterface;
use Psr\Log\LoggerInterface;

final readonly class Client implements HttpClientInterface
{
    /**
     * @param  array<MiddlewareInterface>  $middlewares
     * @param  array<string, string>  $defaultHeaders
     */
    public function __construct(
        private HttpClientInterface $adapter,
        private ?LoggerInterface $logger = null,
        private ?RetryStrategyInterface $retryStrategy = null,
        private array $middlewares = [],
        private array $defaultHeaders = [],
    ) {}

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $logger = $this->logger;

        $existingHeaders = array_change_key_case($request->getHeaders());
        foreach ($this->defaultHeaders as $name => $value) {
            $lowerName = strtolower($name);
            if (! isset($existingHeaders[$lowerName])) {
                $request = $request->withHeader($name, $value);
            }
        }

        $pipeline = $this->buildPipeline();

        $attempts = 0;
        while (true) {
            $attempts++;
            try {
                if ($logger) {
                    $logger->info("Sending HTTP {$request->getMethod()} request to {$request->getUri()} (Attempt {$attempts})");
                }

                $response = $pipeline($request);

                if ($this->retryStrategy && $this->retryStrategy->shouldRetry($attempts, $response, null)) {
                    $delay = $this->retryStrategy->getDelay($attempts);
                    if ($logger) {
                        $logger->warning("Received retryable status {$response->getStatusCode()}. Retrying in {$delay}ms...");
                    }
                    usleep($delay * 1000);

                    continue;
                }

                if ($logger) {
                    $logger->info("Received HTTP {$response->getStatusCode()} response");
                }

                return $response;
            } catch (\Throwable $e) {
                if ($this->retryStrategy && $this->retryStrategy->shouldRetry($attempts, null, $e)) {
                    $delay = $this->retryStrategy->getDelay($attempts);
                    if ($logger) {
                        $logger->warning("Encountered retryable exception: {$e->getMessage()}. Retrying in {$delay}ms...");
                    }
                    usleep($delay * 1000);

                    continue;
                }

                if ($logger) {
                    $logger->error("HTTP request failed: {$e->getMessage()}");
                }

                throw $e;
            }
        }
    }

    /**
     * @return callable(RequestInterface): ResponseInterface
     */
    private function buildPipeline(): callable
    {
        $next = function (RequestInterface $request): ResponseInterface {
            return $this->adapter->sendRequest($request);
        };

        for ($i = count($this->middlewares) - 1; $i >= 0; $i--) {
            $middleware = $this->middlewares[$i];
            $next = function (RequestInterface $request) use ($middleware, $next): ResponseInterface {
                return $middleware->handle($request, $next);
            };
        }

        return $next;
    }
}
