<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

interface RequestInterface
{
    public function getMethod(): string;

    public function getUri(): string;

    /**
     * @return array<string, array<int, string>>
     */
    public function getHeaders(): array;

    public function getBody(): ?string;

    public function withHeader(string $name, string $value): self;
}
