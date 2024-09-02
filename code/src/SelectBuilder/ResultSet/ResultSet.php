<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\ResultSet;

class ResultSet extends AbstractResultSet
{
    public function __construct(
        protected array $data
    ) {
    }

    protected function getData(): array
    {
        return $this->data;
    }
}
