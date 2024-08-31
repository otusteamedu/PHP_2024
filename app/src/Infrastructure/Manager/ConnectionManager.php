<?php

declare(strict_types=1);

namespace App\Infrastructure\Manager;

use App\Infrastructure\Repository\PostgresRepository;
use App\Infrastructure\Repository\MemcacheRepository;
use App\Infrastructure\Repository\RedisRepository;

class ConnectionManager
{
    public function __construct(
        protected PostgresRepository $postgres,
        protected MemcacheRepository $memcache,
        protected RedisRepository $redis
    ) {
    }

    public function getStatus(): string
    {
        $pgStatus = $this->postgres->testConnection();
        $cacheStatus = $this->memcache->testConnection();
        $redisStatus = $this->redis->testConnection();

        return "$pgStatus<br>$cacheStatus<br>$redisStatus";
    }
}
