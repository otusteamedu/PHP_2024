<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Memcache;

class MemcacheRepository
{
    public function __construct(
        protected Memcache $connection
    )
    {
    }

    public function testConnection(): string
    {
        $result = $this->connection->set('test', 'Подключение к Memcached успешно!', 0, 10);
        if ($result) {
            return $this->connection->get('test');
        } else {
            return 'Не удалось подключиться к Memcached.';
        }
    }
}
