<?php

namespace Otus\App\Redis;

class Entry
{
    public \Redis $redis;
    public Config $config;


    public function __construct()
    {
        $config = new Config();
        $this->config = $config;

        $this->redis = new \Redis();
        $connected = $this->redis->connect($_ENV['REDIS_HOST'], (int) $_ENV['REDIS_PORT']);

        if (!$connected) {
            throw new \Exception('Could not connect to Redis');
        }
    }
}
