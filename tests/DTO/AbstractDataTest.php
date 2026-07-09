<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\DTO;

use Gonon\Core\DTO\AbstractData;
use PHPUnit\Framework\TestCase;

readonly class DummyData extends AbstractData
{
    public function __construct(public string $id, public string $name) {}

    public static function fromArray(array $data): static
    {
        /** @phpstan-ignore-next-line */
        return new static((string) ($data['id'] ?? ''), (string) ($data['name'] ?? ''));
    }

    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name];
    }
}

class AbstractDataTest extends TestCase
{
    public function test_it_serializes_to_json(): void
    {
        $data = new DummyData('1', 'Test');

        $this->assertSame(['id' => '1', 'name' => 'Test'], $data->jsonSerialize());

        $json = json_encode($data);
        $this->assertSame('{"id":"1","name":"Test"}', $json);

        $fromArray = DummyData::fromArray(['id' => '2', 'name' => 'Test 2']);
        $this->assertSame('2', $fromArray->id);
    }
}
