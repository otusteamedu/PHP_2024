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
        $connected = $this->redis->connect($this->config->host, $this->config->port);

        if (!$connected) {
            throw new \Exception('Could not connect to Redis');
        }
    }
}
