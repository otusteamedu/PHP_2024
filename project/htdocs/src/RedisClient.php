<?php

namespace App;

use Predis\Client;

class RedisClient
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host' => 'MyRedis',
            'port' => 6379,
        ]);
    }

    public function getClient(): Client
    {
        return $this->redis;
    }
}