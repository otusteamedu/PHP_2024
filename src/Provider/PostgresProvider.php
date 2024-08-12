<?php

declare(strict_types=1);

namespace App\Provider;

use PDO;

class PostgresProvider implements DatabaseProviderInterface
{
    private PDO $connection;
    public function __construct()
    {
        try {
            $pdo = new PDO(
                "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}",
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                []
            );
            $this->connection = $pdo;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
