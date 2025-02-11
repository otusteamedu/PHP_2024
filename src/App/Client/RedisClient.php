<?php

namespace App\Client;

use App\App;

class RedisClient
{
    private array $env;
    private \Redis $client;

    public function __construct()
    {
        $this->env = App::env();
        $this->connect();
    }

    public function connect()
    {
        $this->client = new \Redis();
        $this->client->connect($this->env['REDIS_HOST'], $this->env['REDIS_PORT']);

        try {
            $this->client->ping();
        } catch (\Exception $e) {
            die("Redis connection failed: " . $e->getMessage());
        }
    }

    public function zAdd($key, $score, $value)
    {
        $this->client->zAdd($key, $score, $value);
    }

    public function zRevRange($key, $from, $to)
    {
        return $this->client->zRevRange($key, $from, $to);
    }

    public function deleteAll()
    {
        $this->client->flushAll();
    }
}