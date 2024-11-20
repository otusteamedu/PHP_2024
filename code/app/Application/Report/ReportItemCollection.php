<?php

declare(strict_types=1);

namespace App\Application\Report;

use InvalidArgumentException;
use Iterator;

class ReportItemCollection implements Iterator
{
    protected int $position = 0;

    public function __construct(
        private array $data = []
    )
    {
        foreach ($this->data as $item) {
            if (!($item instanceof ReportItem)) {
                throw new InvalidArgumentException('Item must be ReportItem type');
            }
        }
    }

    public function append(ReportItem $item): void
    {
        $this->data[] = $item;
    }

    public function current(): ReportItem
    {
        return $this->data[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->data[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
