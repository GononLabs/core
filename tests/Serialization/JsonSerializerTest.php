<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Serialization;

use Gonon\Core\Serialization\JsonSerializer;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    public function test_json_serializer(): void
    {
        $serializer = new JsonSerializer();

        $data = ['id' => 1, 'name' => 'test'];
        $json = $serializer->serialize($data);

        $this->assertSame('{"id":1,"name":"test"}', $json);

        $deserialized = $serializer->deserialize($json, 'array');
        $this->assertSame($data, $deserialized);
    }
}
