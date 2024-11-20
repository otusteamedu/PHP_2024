<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

use Redis;
use RedisException;

class RedisStorage implements EventStorage
{
    private const KEY = 'events';
    private Redis $redis;

    /**
     * @throws RedisException
     */
    public function __construct(RedisConfig $redisConfig)
    {
        $this->redis = new Redis();
        $this->redis->connect($redisConfig->host, $redisConfig->port);
    }

    /**
     * @throws RedisException
     */
    public function addEvent(Event $event): void
    {
        $this->redis->zAdd(self::KEY, $event->priority, json_encode($event));
    }

    /**
     * @return array
     * @throws RedisException
     */
    public function getEvents(): array
    {
        $eventData = $this->redis->zRevRange(self::KEY, 0, -1);
        if (empty($eventData)) {
            return [];
        }

        return array_map(function ($encodedEvent) {
            $event = json_decode($encodedEvent, true);
            return new Event($event['priority'], $event['conditions'], $event['event']);
        }, $eventData);
    }

    /**
     * @throws RedisException
     */
    public function clearEvents(): void
    {
        $this->redis->del(self::KEY);
    }
}
