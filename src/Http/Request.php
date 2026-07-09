<?php

declare(strict_types=1);

namespace Gonon\Core\Http;

use Gonon\Core\Contracts\RequestInterface;

final readonly class Request implements RequestInterface
{
    /**
     * @param  array<string, array<int, string>>  $headers
     */
    public function __construct(
        private string $method,
        private string $uri,
        private array $headers = [],
        private ?string $body = null,
    ) {}

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function withHeader(string $name, string $value): self
    {
        $headers = $this->headers;
        $headers[$name][] = $value;

        return new self($this->method, $this->uri, $headers, $this->body);
    }
}
