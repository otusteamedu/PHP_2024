<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\ResultSet;

class ResultSet extends AbstractResultSet
{
    /**
     * @param array $data
     */
    public function __construct(
        protected array $data
    ) {
    }

    /**
     * @return array
     */
    protected function getData(): array
    {
        return $this->data;
    }
}
