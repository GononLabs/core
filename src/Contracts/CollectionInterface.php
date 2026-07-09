<?php

declare(strict_types=1);

namespace Gonon\Core\Contracts;

use Countable;
use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends IteratorAggregate<TKey, TValue>
 */
interface CollectionInterface extends Countable, IteratorAggregate
{
    /**
     * @return TValue|null
     */
    public function first(): mixed;

    /**
     * @return TValue|null
     */
    public function last(): mixed;

    /**
     * @param  callable(TValue, TKey): mixed  $callback
     * @return self<TKey, mixed>
     */
    public function map(callable $callback): self;

    /**
     * @param  callable(TValue, TKey): bool  $callback
     * @return self<TKey, TValue>
     */
    public function filter(callable $callback): self;

    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array;
}
