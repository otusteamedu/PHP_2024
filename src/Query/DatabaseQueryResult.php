<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Query;

use Iterator;
use PDO;
use PDOStatement;
use stdClass;

class DatabaseQueryResult implements Iterator
{
    protected PDO $pdo;
    protected PDOStatement $pdoStatement;
    protected int $key;
    protected stdClass|bool $result;

    public function __construct(string $query, PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->execute($query);
    }

    protected function execute(string $query): void
    {
        $this->pdoStatement = $this->pdo->query($query);
    }

    public function current(): stdClass|bool
    {
        return $this->result;
    }

    public function next(): bool
    {
        $this->key++;
        $this->result = $this->pdoStatement->fetch(
            \PDO::FETCH_OBJ,
            \PDO::FETCH_ORI_ABS,
            $this->key
        );

        return (bool)$this->result;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function valid(): bool
    {
        if (!$this->next()) {
            return false;
        }
        return true;
    }

    public function rewind(): void
    {
        $this->key = 0;
    }
}
