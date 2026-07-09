<?php

declare(strict_types=1);

namespace Gonon\Core\Serialization;

use Gonon\Core\Contracts\SerializerInterface;

final readonly class ArraySerializer implements SerializerInterface
{
    public function serialize(mixed $data): string
    {
        return serialize($data);
    }

    public function deserialize(string $data, string $type): mixed
    {
        return unserialize($data, ['allowed_classes' => [$type]]);
    }
}
