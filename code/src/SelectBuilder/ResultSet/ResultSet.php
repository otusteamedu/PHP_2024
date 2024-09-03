<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\ResultSet;

use Iterator;

class ResultSet implements Iterator
{
    /** @var int */
    protected int $position = 0;

    /**
     * @param array $data
     */
    public function __construct(
        protected array $data
    ) {
    }

    /**
     * @inheritDoc
     */
    public function current(): array
    {
        return $this->data[$this->position];
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
        return isset($this->data[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->position = 0;
    }
}
