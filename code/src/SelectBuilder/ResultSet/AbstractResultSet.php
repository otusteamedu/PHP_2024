<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\ResultSet;

abstract class AbstractResultSet implements \Iterator
{
    protected int $position = 0;

    abstract protected function getData(): array;

    /**
     * @inheritDoc
     */
    public function current(): array

    {
        $data = $this->getData();
        return $data[$this->position];
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        $data = $this->getData();

        return isset($data[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->position = 0;
    }
}
