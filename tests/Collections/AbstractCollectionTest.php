<?php

declare(strict_types=1);

namespace Gonon\Core\Tests\Collections;

use Gonon\Core\Collections\AbstractCollection;
use PHPUnit\Framework\TestCase;

/**
 * @extends AbstractCollection<int|string, int>
 */
readonly class DummyCollection extends AbstractCollection {}

class AbstractCollectionTest extends TestCase
{
    public function test_collection_methods(): void
    {
        $collection = new DummyCollection(['a' => 1, 'b' => 2, 'c' => 3]);

        $this->assertSame(1, $collection->first());
        $this->assertSame(3, $collection->last());
        $this->assertCount(3, $collection);
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $collection->toArray());

        $mapped = $collection->map(fn ($item, $key) => $item * 2);
        $this->assertSame(['a' => 2, 'b' => 4, 'c' => 6], $mapped->toArray());

        $filtered = $collection->filter(fn ($item) => $item > 1);
        $this->assertSame(['b' => 2, 'c' => 3], $filtered->toArray());

        $items = [];
        foreach ($collection as $key => $value) {
            $items[$key] = $value;
        }
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $items);

        $empty = new DummyCollection();
        $this->assertNull($empty->first());
        $this->assertNull($empty->last());
    }
}
