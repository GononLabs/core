<?php

declare(strict_types=1);

namespace Gonon\Core\Testing;

use Gonon\Core\Contracts\HttpClientInterface;
use Gonon\Core\Contracts\RequestInterface;
use Gonon\Core\Contracts\ResponseInterface;

class FakeHttpClient implements HttpClientInterface
{
    /**
     * @var array<int, MockResponse>
     */
    private array $queue = [];

    public function __construct(
        private readonly RequestRecorder $recorder = new RequestRecorder()
    ) {}

    public function queueResponse(ResponseInterface $response): self
    {
        $this->queue[] = new MockResponse($response);

        return $this;
    }

    public function queueException(\Throwable $exception): self
    {
        $this->queue[] = new MockResponse(ResponseFactory::create(0), $exception);

        return $this;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->recorder->record($request);

        if (empty($this->queue)) {
            return ResponseFactory::create(200);
        }

        $mockResponse = array_shift($this->queue);

        if ($mockResponse->getException() !== null) {
            throw $mockResponse->getException();
        }

        return $mockResponse->getResponse();
    }

    public function getRecorder(): RequestRecorder
    {
        return $this->recorder;
    }
}
