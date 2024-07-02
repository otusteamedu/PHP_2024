<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use IteratorAggregate;
use Countable;
use ArrayIterator;
use App\Domain\ValueObject\Stock;

class StockCollection implements IteratorAggregate, Countable
{
    /**
     * @var Stock[]
     */
    private array $stocks = [];

    public function __construct(array $stocks = [])
    {
        foreach ($stocks as $stock) {
            $this->add($stock);
        }
    }

    public function add(Stock $stock): void
    {
        $this->stocks[] = $stock;
    }

    /**
     * @return Stock[]
     */
    public function getStocks(): array
    {
        return $this->stocks;
    }


    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->stocks);
    }

    public function count(): int
    {
        return count($this->stocks);
    }

    public function __toString()
    {
        return implode(', ', $this->stocks);
    }
}
