<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\QueryResult;

class QueryResult extends AbstractQueryResult
{
    private array $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    protected function getRows(): array
    {
        return $this->rows;
    }
}
