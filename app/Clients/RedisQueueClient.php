<?php

namespace App\Clients;

use App\Contracts\QueueClientInterface;
use Redis;

class RedisQueueClient implements QueueClientInterface
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
    }

    public function connect(string $host, int $port): void
    {
        $this->redis->connect($host, $port);
    }

    public function push(string $queue, $data): void
    {
        $this->redis->lPush($queue, json_encode($data));
    }

    public function pop(string $queue): ?array
    {
        $data = $this->redis->rPop($queue);
        return $data ? json_decode($data, true) : null;
    }
}