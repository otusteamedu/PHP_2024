<?php

declare(strict_types=1);

namespace App\Service;

use Redis;

class RedisConnectorService
{
    public function __construct(private readonly string $redisHost)
    {
    }

    public function connect(): Redis {
        $redis = new Redis();
        $redis->connect($this->redisHost);

        return $redis;
    }
}