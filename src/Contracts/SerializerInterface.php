<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

interface SerializerInterface
{
    public function serialize(mixed $data): string;

    public function deserialize(string $data, string $type): mixed;
}
