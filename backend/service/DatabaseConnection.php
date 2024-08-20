<?php

declare(strict_types=1);

namespace Service;

final class DatabaseConnection
{
    private readonly \PDO $connection;
    public function __construct()
    {
        try {
            $dsn = "pgsql:host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME') . ";user=" . getenv('DB_USER') . ";password=" . getenv('DB_PASSWORD');
            $this->connection = new \PDO($dsn);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}
