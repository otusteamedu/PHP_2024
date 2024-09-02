<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder;

use PDO;
use Viking311\Builder\SelectBuilder\ResultSet\AbstractResultSet;
use Viking311\Builder\SelectBuilder\ResultSet\ProxyResultSet;
use Viking311\Builder\SelectBuilder\ResultSet\ResultSet;

class SelectBuilder
{
    private string $table;
    private array $where = [];
    private ?string $orderField = null;
    private string $orderDirection;

    public function __construct(
        readonly private PDO $db
    )
    {
    }


    public function from(string $table): SelectBuilder
    {
        $this->table = $table;

        return $this;
    }

    public function where(
        string $field,
        string $value
    ): SelectBuilder
    {
        $this->where[$field] = $value;

        return $this;
    }

    public function orderBy(
        string $field,
        string $direction = 'asc'
    ): SelectBuilder
    {
        $this->orderField = $field;
        $this->orderDirection = $direction;

        return $this;
    }

    public function execute(bool $lazy = false): AbstractResultSet
    {
        $query = 'SELECT * FROM ' . $this->table;

        $query .= ' ' . $this->buildWhere();
        $query .= ' ' . $this->buildOrderBy();

        $sth = $this->db->prepare($query);

        if ($lazy) {
            $result = new ProxyResultSet($sth);
        } else {
            $sth->execute();
            $result = new ResultSet(
                $sth->fetchAll(PDO::FETCH_ASSOC)
            );
        }

        return $result;
    }

    private function buildWhere(): string
    {
        $wheres = [];
        foreach ($this->where as $field =>$value) {
            $wheres[] = $field . '=' . $value;
        }
        if (empty($wheres)) {
            return '';
        }

        return 'WHERE ' . implode(' AND ', $wheres);
    }

    private function buildOrderBy(): string
    {
        if (!is_null($this->orderField)) {
            return "ORDER BY $this->orderField $this->orderDirection";
        }

        return '';
    }
}
