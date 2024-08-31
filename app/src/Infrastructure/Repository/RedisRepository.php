<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Redis;

class RedisRepository
{
    public function __construct(
        protected Redis $connection
    ) {
    }

    public function testConnection(): string
    {
        try {
            $this->connection->set("test", "Подключение к Redis успешно!");
            return $this->connection->get("test");
        } catch (\Exception $e) {
            return 'Не удалось подключиться к Redis: ' . $e->getMessage();
        }
    }
}
