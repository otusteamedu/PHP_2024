<?php

declare(strict_types=1);

namespace App\Storages;

use App\Clients\RedisClient;

class RedisEventStorage implements EventStorageInterface
{
    private \Redis $client;

    public function __construct()
    {
        $this->client = (new RedisClient())->getClient();
    }

    /**
     * @throws \RedisException
     */
    public function add(string $key, int $score, string $value): false|int
    {
        return $this->client->zadd($key, $score, $value);
    }

    /**
     * @throws \RedisException
     */
    public function rangeByScore(string $key, string $min, string $max): ?array
    {
        $events = $this->client->zrangebyscore($key, $min, $max);

        return array_map(fn($json) => json_decode($json, true), $events);
    }

    /**
     * @throws \RedisException
     */
    public function delete(string $key): false|int
    {
        return $this->client->del($key);
    }
}
