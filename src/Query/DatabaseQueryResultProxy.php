<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Query;

class DatabaseQueryResultProxy extends DatabaseQueryResult
{
    private string $query;

    public function __construct(string $query)
    {
        parent::__construct($query);
    }

    protected function execute(string $query): void
    {
        $this->query = $query;
    }

    public function next(): bool
    {
        if ($this->key === 0) {
            $this->pdoStatement = $this->pdo->query($this->query);
        }

        return parent::next();
    }
}
