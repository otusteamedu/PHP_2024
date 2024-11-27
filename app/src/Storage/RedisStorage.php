<?php

namespace App\Storage;

use Predis\Client;

class RedisStorage implements StorageInterface
{
    private Client $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function save(string $key, array $data): void
    {
        $this->redis->set($key,json_encode($data));
    }

    public function get(string $key): ?array
    {
        $data = $this->redis->get($key);
        return $data ? json_decode($data, true) : null;
    }

    public function getAll(string $pattern): array
    {
        $keys = $this->redis->keys($pattern);
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get($key);
        }
        return $results;
    }

    public function delete(string $key): void
    {
        $this->redis->del($key);
    }

    public function clear(string $pattern): void
    {
        $keys = $this->redis->keys($pattern);
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

}