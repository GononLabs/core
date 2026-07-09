<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

interface ResponseInterface
{
    public function getStatusCode(): int;

    /**
     * @return array<string, array<int, string>>
     */
    public function getHeaders(): array;

    public function getBody(): string;
}
