<?php

namespace KRudenko\Otus\Service\Storage;

use Predis\Client;

class RedisStorage implements StorageInterface
{
    private Client $redis;

    public function __construct()
    {
        $this->redis = new Client($_ENV['REDIS_HOST']);
    }

    public function addEvent(array $event): int
    {
        $id = $this->redis->incr('event:id');
        $key = "event:$id";

        $this->redis->hset($key, 'priority', $event['priority']);
        $this->redis->hset($key, 'conditions', json_encode($event['conditions']));
        $this->redis->hset($key, 'event', json_encode($event['event']));
        $this->redis->zadd('events:priorities', [$id => $event['priority']]);

        return $id;
    }

    public function clearEvents(): void
    {
        $keys = $this->redis->keys('event:*');
        if (!empty($keys)) {
            $this->redis->del($keys);
        }
        $this->redis->del('events:priorities', 'event:id');
    }

    public function getAllEventsSortedByPriority(): array
    {
        return $this->redis->zrevrange('events:priorities', 0, -1);
    }

    public function getEventData(int $id): array
    {
        $key = "event:$id";
        return [
            'conditions' => json_decode($this->redis->hget($key, 'conditions'), true),
            'event' => json_decode($this->redis->hget($key, 'event'), true),
            'priority' => (int)$this->redis->hget($key, 'priority')
        ];
    }
}
