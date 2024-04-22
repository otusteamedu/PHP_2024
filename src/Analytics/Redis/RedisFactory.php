<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Redis;

use Redis;

class RedisFactory
{
    public function __construct()
    {
    }

    public function createWithNoAuthentication(string $host, int $port): Redis
    {
        $redis = new Redis();
        $redis->connect($host, $port);
        return $redis;
    }

    public function createWithPasswordAuthentication(string $host, int $port, string $password): Redis
    {
        $redis = new Redis();
        $redis->connect($host, $port);
        $redis->auth($password);
        return $redis;
    }
}
