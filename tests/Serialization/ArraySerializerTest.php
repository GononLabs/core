<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Serialization;

use Gonon\Core\Serialization\ArraySerializer;
use PHPUnit\Framework\TestCase;

class ArraySerializerTest extends TestCase
{
    public function test_array_serializer(): void
    {
        $serializer = new ArraySerializer();

        $data = ['id' => 1, 'name' => 'test'];
        $serialized = $serializer->serialize($data);

        $this->assertIsString($serialized);

        $deserialized = $serializer->deserialize($serialized, 'array');
        $this->assertSame($data, $deserialized);
    }
}
