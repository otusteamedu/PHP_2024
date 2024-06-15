<?php

declare(strict_types=1);

namespace Afilipov\Hw16\iterator;

use Iterator;

class StatusIterator implements Iterator
{
    private array $statuses;
    private int $position = 0;

    public function __construct(array $statuses)
    {
        $this->statuses = $statuses;
    }

    public function current(): ProductStatus
    {
        return $this->statuses[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function valid(): bool
    {
        return isset($this->statuses[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
