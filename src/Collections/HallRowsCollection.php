<?php

namespace AleksandrOrlov\Php2024\Collections;

use AleksandrOrlov\Php2024\Entities\HallRow;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

class HallRowsCollection implements IteratorAggregate
{
    /** @var HallRow[] */
    private array $list = [];

    public function add(HallRow $hallRow): void
    {
        $this->list[] = $hallRow;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }
}
