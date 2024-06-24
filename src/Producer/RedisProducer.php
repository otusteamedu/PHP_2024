<?php

declare(strict_types=1);

namespace App\Producer;

use Predis\Client as RedisClient;

readonly class RedisProducer implements ProducerInterface
{
    public function __construct(private RedisClient $redis)
    {
    }

    public function publish(array $msgBody, string $queueName): void
    {
        $this->redis->lpush($queueName, json_encode($msgBody));
    }
}
