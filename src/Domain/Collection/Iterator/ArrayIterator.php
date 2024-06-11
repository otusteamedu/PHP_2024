<?php

declare(strict_types=1);

namespace App\Domain\Collection\Iterator;

use Iterator;

class ArrayIterator implements Iterator
{
    private int $position = 0;
    public function __construct(
        private array $elements,
    ) {
    }

    public function current(): mixed
    {
        return $this->elements[$this->position] ?? null;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
       return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->elements[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
