<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\QueryResult;

use Closure;

class ProxyQueryResult extends AbstractQueryResult
{
    private ?array $rows = null;
    private Closure $getRowsClosure;

    public function __construct(Closure $getRowsClosure)
    {
        $this->getRowsClosure = $getRowsClosure;
    }

    protected function getRows(): array
    {
        if ($this->rows === null) {
            $this->rows = ($this->getRowsClosure)();
        }

        return $this->rows;
    }
}
