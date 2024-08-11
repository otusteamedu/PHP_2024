<?php

namespace Service;

class RedisConnection
{
    private \Redis $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
    }

    public function getRedis(): \Redis
    {
        return $this->redis;
    }
}
