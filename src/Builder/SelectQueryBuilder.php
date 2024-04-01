<?php

namespace AleksandrOrlov\Php2024\Builder;

use Exception;
use AleksandrOrlov\Php2024\Query\DatabaseQueryResult;

class SelectQueryBuilder
{
    private string $query = 'SELECT * ';
    private string $from;
    private array $wheres = [];
    private array $orders = [];

    public function from(string $table): SelectQueryBuilder
    {
        $this->from = $table;
        return $this;
    }

    public function where(string $field, string $value): SelectQueryBuilder
    {
        $this->wheres[] = "$field = '$value'";
        return $this;
    }

    public function orderBy(string $field, string $direction): SelectQueryBuilder
    {
        $this->orders = [
            'column' => $field,
            'direction' => $direction,
        ];
        return $this;
    }

    public function getSQL(): string
    {
        if (empty($this->from)) {
            throw new Exception('No table specified');
        }

        $this->query .= "FROM $this->from";

        if (!empty($this->wheres)) {
            $this->query .= " WHERE " . implode(' AND ', $this->wheres);
        }

        if (!empty($this->orders)) {
            $this->query .= " ORDER BY {$this->orders['column']} {$this->orders['direction']}";
        }

        $this->query .= ";";

        return $this->query;
    }

    public function execute(): DatabaseQueryResult
    {
        return new DatabaseQueryResult($this->getSQL());
    }
}
