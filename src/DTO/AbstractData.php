<?php

declare(strict_types=1);

namespace Gonon\Core\DTO;

use JsonSerializable;

abstract readonly class AbstractData implements JsonSerializable
{
    /**
     * @param  array<string, mixed>  $data
     */
    abstract public static function fromArray(array $data): static;

    /**
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
