<?php

namespace Ahar\Hw12\storage;

use Ahar\Hw12\Event;
use Redis;

class RedisStorage implements Storage
{
    private Redis $redis;

    public function __construct(RedisConfig $config)
    {
        $this->redis = new Redis();
        $this->redis->connect($config->host, $config->port);
    }

    public function add(string $key, Event $event): void
    {
        $eventParams = [
            'priority' => $event->priority,
            'conditions' => $event->conditions,
            'event' => $event->event,
        ];

        $this->redis->zAdd($key, $event->priority, json_encode($eventParams, JSON_THROW_ON_ERROR));
    }

    public function get(string $key): array
    {
        $eventData = $this->redis->zRevRange($key, 0, -1);
        if (empty($eventData)) {
            return [];
        }

        return array_map(static function ($encodedEvent) {
            $event = json_decode($encodedEvent, true, 512, JSON_THROW_ON_ERROR);
            return new Event($event['priority'], $event['conditions'], $event['event']);
        }, $eventData);
    }

    public function clear(string $key): void
    {
        $this->redis->del($key);
    }
}
