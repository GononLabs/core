<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Http;

use Gonon\Core\Contracts\HttpClientInterface;
use Gonon\Core\Contracts\MiddlewareInterface;
use Gonon\Core\Contracts\RequestInterface;
use Gonon\Core\Contracts\ResponseInterface;
use Gonon\Core\Contracts\RetryStrategyInterface;
use Gonon\Core\Http\Client;
use Gonon\Core\Http\Request;
use Gonon\Core\Http\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function test_it_sends_request(): void
    {
        $adapter = $this->createMock(HttpClientInterface::class);

        $request = new Request('POST', 'https://example.com', ['Accept' => ['application/json']], 'body');
        $expectedResponse = new Response(200, ['Content-Type' => ['application/json']], 'response_body');

        $adapter->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($expectedResponse);

        $client = new Client($adapter);
        $response = $client->sendRequest($request);

        $this->assertSame(200, $response->getStatusCode());
    }

    public function test_it_applies_default_headers(): void
    {
        $adapter = $this->createMock(HttpClientInterface::class);

        $request = new Request('GET', 'https://example.com');
        $expectedResponse = new Response(200, [], '');

        $adapter->expects($this->once())
            ->method('sendRequest')
            ->willReturnCallback(function (RequestInterface $req) use ($expectedResponse) {
                $this->assertSame(['User-Agent' => ['GononSDK']], $req->getHeaders());

                return $expectedResponse;
            });

        $client = new Client($adapter, null, null, [], ['User-Agent' => 'GononSDK']);
        $client->sendRequest($request);
    }

    public function test_it_executes_middlewares(): void
    {
        $adapter = $this->createMock(HttpClientInterface::class);

        $request = new Request('GET', 'https://example.com');
        $transportResponse = new Response(200, [], 'transport');

        $adapter->expects($this->once())
            ->method('sendRequest')
            ->willReturnCallback(function (RequestInterface $req) use ($transportResponse) {
                $this->assertSame(['X-Middleware' => ['applied']], $req->getHeaders());

                return $transportResponse;
            });

        $middleware = new class() implements MiddlewareInterface
        {
            public function handle(RequestInterface $request, callable $next): ResponseInterface
            {
                $request = $request->withHeader('X-Middleware', 'applied');
                $response = $next($request);

                return new Response(201, $response->getHeaders(), $response->getBody().'_mutated');
            }
        };

        $client = new Client($adapter, null, null, [$middleware]);
        $response = $client->sendRequest($request);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('transport_mutated', $response->getBody());
    }

    public function test_it_retries_on_exception(): void
    {
        $adapter = $this->createMock(HttpClientInterface::class);

        $request = new Request('GET', 'https://example.com');

        $adapter->expects($this->exactly(2))
            ->method('sendRequest')
            ->willReturnOnConsecutiveCalls(
                $this->throwException(new \RuntimeException('Network fail')),
                new Response(200, [], 'success')
            );

        $retryStrategy = $this->createMock(RetryStrategyInterface::class);
        $retryStrategy->expects($this->exactly(2))
            ->method('shouldRetry')
            ->willReturnOnConsecutiveCalls(true, false);
        $retryStrategy->expects($this->once())
            ->method('getDelay')
            ->willReturn(1);

        $client = new Client($adapter, null, $retryStrategy);
        $response = $client->sendRequest($request);

        $this->assertSame(200, $response->getStatusCode());
    }
}
