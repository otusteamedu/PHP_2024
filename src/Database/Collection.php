<?php

namespace KRudenko\Otus\Database;

use ArrayIterator;
use IteratorAggregate;
use ReturnTypeWillChange;

class Collection implements IteratorAggregate
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    #[ReturnTypeWillChange]
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
