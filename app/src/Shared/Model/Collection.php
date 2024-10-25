<?php

declare(strict_types=1);

namespace App\Shared\Model;

use Countable;

/**
 * @template TItem
 */
class Collection implements Countable
{
    /**
     * @param array<TItem> $items
     */
    public function __construct(
        protected array $items = [],
    ) {}

    /**
     * @return array<TItem>
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @return TItem | null
     */
    public function first(): mixed
    {
        return current($this->items) ?: null;
    }

    public function count(): int
    {
        return count($this->all());
    }
}
