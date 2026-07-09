<?php

declare(strict_types=1);

namespace Gonon\Core\Collections;

use ArrayIterator;
use Gonon\Core\Contracts\CollectionInterface;
use Traversable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements CollectionInterface<TKey, TValue>
 */
abstract readonly class AbstractCollection implements CollectionInterface
{
    /**
     * @param  array<TKey, TValue>  $items
     */
    public function __construct(
        protected array $items = [],
    ) {}

    public function first(): mixed
    {
        $key = array_key_first($this->items);

        if ($key === null) {
            return null;
        }

        return $this->items[$key];
    }

    public function last(): mixed
    {
        $key = array_key_last($this->items);

        if ($key === null) {
            return null;
        }

        return $this->items[$key];
    }

    /**
     * @param  callable(TValue, TKey): mixed  $callback
     * @return static
     */
    public function map(callable $callback): self
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);

        // @phpstan-ignore-next-line
        return new static(array_combine($keys, $items));
    }

    /**
     * @param  callable(TValue, TKey): bool  $callback
     * @return static
     */
    public function filter(callable $callback): self
    {
        // @phpstan-ignore-next-line
        return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
