<?php

declare(strict_types=1);

namespace App\Service;

class RedisConnectorService
{
    public function connect(): \Redis {
        $redis = new \Redis();
        $redis->connect('redis');

        return $redis;
    }
}