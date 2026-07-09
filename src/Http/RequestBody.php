<?php

declare(strict_types=1);

namespace Gonon\Core\Http;

final readonly class RequestBody
{
    public function __construct(
        private ?string $contents = null,
    ) {}

    public function getContents(): ?string
    {
        return $this->contents;
    }
}
