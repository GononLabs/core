<?php

declare(strict_types=1);

namespace Gonon\Core\Http;

use Gonon\Core\Contracts\ResponseInterface;

final readonly class Response implements ResponseInterface
{
    /**
     * @param  array<string, array<int, string>>  $headers
     */
    public function __construct(
        private int $statusCode,
        private array $headers = [],
        private string $body = '',
    ) {}

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
