<?php

namespace AKornienko\Php2024\Infrastructure;

use AKornienko\Php2024\Application\StorageClient;
use AKornienko\Php2024\Domain\Event;
use Exception;
use Redis;
use RedisException;

class RedisClient extends StorageClient
{
    const EVENTS_SET_NAME = 'events';
    private Redis $redis;

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function __construct($config)
    {
        $this->redis = new Redis();
        $this->redis->connect($config->redisHost, $config->redisPort);
        if (!$this->redis->ping()) {
            throw new Exception("can't connect redis");
        }
    }

    /**
     * @throws RedisException
     * @throws \RedisException
     */
    public function addEvent(string $key, int $priority, Event $event): int|false
    {
        $this->saveEventKey($key);
        return $this->redis->zAdd($key, $priority, json_encode($event->getValue()));
    }

    /**
     * @throws RedisException|\RedisException
     */
    public function getEvent(string $key): array
    {
        return $this->redis->zRevRange($key, 0, 0);
    }

    /**
     * @throws RedisException|\RedisException
     */
    public function removeAllEvents(): false|int
    {
        $allEvents = $this->getAllEventsKeys();
        if (is_array($allEvents)) {
            return $this->redis->del($allEvents);
        }
        return false;
    }

    private function saveEventKey(string $key): void
    {
        $this->redis->sAdd(self::EVENTS_SET_NAME, $key);
    }

    /**
     * @throws \RedisException
     */
    private function getAllEventsKeys(): false|array|Redis
    {
        return $this->redis->sMembers(self::EVENTS_SET_NAME);
    }
}
