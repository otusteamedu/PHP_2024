<?php

namespace App\Storage;

use Predis\Client;

class RedisEventStorage implements EventStorageInterface
{
    private Client $redis;
    private string $eventListKey;

    public function __construct(Client $redis, string $eventListKey = 'events')
    {
        $this->redis = $redis;
        $this->eventListKey = $eventListKey;
    }

    public function addEvent(array $event): void
    {
        $this->redis->rpush($this->eventListKey, json_encode($event));
    }

    public function clearEvents(): void
    {
        $this->redis->del([$this->eventListKey]);
    }

    public function getBestMatchingEvent(array $params): ?array
    {
        $events = $this->redis->lrange($this->eventListKey, 0, -1);
        $bestEvent = null;
        $highestPriority = PHP_INT_MIN;

        foreach ($events as $eventJson) {
            $event = json_decode($eventJson, true);
            if ($this->matches($event['conditions'], $params) && $event['priority'] > $highestPriority) {
                $bestEvent = $event;
                $highestPriority = $event['priority'];
            }
        }

        return $bestEvent;
    }

    private function matches(array $conditions, array $params): bool
    {
        foreach ($conditions as $key => $value) {
            if (!isset($params[$key]) || $params[$key] !== $value) {
                return false;
            }
        }
        return true;
    }
}
