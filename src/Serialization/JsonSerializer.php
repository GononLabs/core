<?php

declare(strict_types=1);

namespace Gonon\Core\Serialization;

use Gonon\Core\Contracts\SerializerInterface;

final readonly class JsonSerializer implements SerializerInterface
{
    public function serialize(mixed $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function deserialize(string $data, string $type): mixed
    {
        // A full implementation would map the decoded array to the specified $type
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }
}
