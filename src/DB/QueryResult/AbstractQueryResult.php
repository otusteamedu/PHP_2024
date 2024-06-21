<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\QueryResult;

abstract class AbstractQueryResult implements QueryResultInterface
{
    private int $currentIndex = 0;

    public function current(): mixed
    {
        return $this->getRows()[$this->currentIndex];
    }

    public function next(): void
    {
        $this->currentIndex++;
    }

    public function key(): int
    {
        return $this->currentIndex;
    }

    public function valid(): bool
    {
        return $this->currentIndex < count($this->getRows());
    }

    public function rewind(): void
    {
        $this->currentIndex = 0;
    }

    abstract protected function getRows(): array;
}
