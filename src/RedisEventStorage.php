<?php

declare(strict_types=1);

namespace App;

class RedisEventStorage implements EventStorageInterface
{
    private \Redis $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('redis', 6379);
    }

    public function add(array $event): void
    {
        $priority = $event['priority'] ?? 0;
        $this->redis->zAdd('events', $priority, json_encode($event));
    }

    public function get(array $params): ?array
    {
        $events = $this->redis->zRevRangeByScore('events', '+inf', '-inf');
        $result = null;
        foreach ($events as $event) {
            $event = json_decode($event, true);
            $match = true;
            foreach ($event['conditions'] as $conditionName => $conditionValue) {
                if (!isset($params[$conditionName]) || $params[$conditionName] != $conditionValue) {
                    $match = false;
                    break;
                }
            }
            if ($match) {
                $result = $event;
                break;
            }
        }
        return $result;
    }

    public function clear(): void
    {
        $this->redis->del('events');
    }
}