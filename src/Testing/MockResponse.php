<?php

declare(strict_types=1);

namespace Gonon\Core\Testing;

use Gonon\Core\Contracts\ResponseInterface;

final readonly class MockResponse
{
    public function __construct(
        private ResponseInterface $response,
        private ?\Throwable $exception = null
    ) {}

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getException(): ?\Throwable
    {
        return $this->exception;
    }
}
