<?php

declare(strict_types=1);

namespace Gonon\Core\Http;

final readonly class ResponseBody
{
    public function __construct(
        private string $contents = '',
    ) {}

    public function getContents(): string
    {
        return $this->contents;
    }
}
