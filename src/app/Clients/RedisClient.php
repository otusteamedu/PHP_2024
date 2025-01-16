<?php

declare(strict_types=1);

namespace App\Clients;

class RedisClient
{
    private \Redis $client;

    public function __construct(string $host = 'redis', int $port = 6379)
    {
        try {
            $this->client = new \Redis();
            $this->client->connect($host, $port);
        } catch (\RedisException $e) {
            exit('Connect to Redis error');
        }
    }

    public function getClient(): \Redis
    {
        return $this->client;
    }
}
