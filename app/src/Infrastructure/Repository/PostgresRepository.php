<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use PDO;

class PostgresRepository
{
    public function __construct(
        protected PDO $connection
    )
    {
    }

    public function testConnection(): string
    {
        try {
            $stmt = $this->connection->query('SELECT 1');
            if ($stmt) {
                return 'Подключение к PostgreSQL успешно!';
            } else {
                return 'Не удалось выполнить запрос.';
            }
        } catch (\PDOException $e) {
            return 'Не удалось подключиться к PostgreSQL: ' . $e->getMessage();
        }
    }
}
