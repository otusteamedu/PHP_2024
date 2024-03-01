<?php

namespace RedisConnector;

use Redis;
use RedisException;

class RedisConnector
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
    }

    public function connect(): bool
    {
        try {
            $this->redis->connect('redis', 6379);
            return true;
        } catch (RedisException $e) {
            return false;
        }
    }
}