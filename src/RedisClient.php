<?php

declare(strict_types=1);

namespace AShutov\Hw15;

use AShutov\Hw15\Requests\AddEventRequest;
use Exception;
use Redis;
use RedisException;

class RedisClient implements StorageClientInterface
{
    const EVENTS_NAME = 'events';
    private Redis $redis;

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function __construct($config)
    {
        $this->redis = new Redis();
        $this->redis->connect($config->redisHost, $config->redisPort);
        $this->redis->auth($config->redisPassword);

        if (!$this->redis->ping()) {
            throw new Exception("Redis connect fail");
        }
    }

    /**
     * @throws RedisException
     */
    public function addEvent(string $key, AddEventRequest $value): int|false
    {
        $this->saveEventKey($key);

        return $this->redis->zAdd($key, $value->priority, $value->event);
    }

    /**
     * @throws RedisException
     */
    public function getEvent(string $key): array
    {
        return $this->redis->zRevRange($key, 0, 0);
    }

    /**
     * @throws RedisException
     */
    public function removeAllEvents(): false|int
    {
        $allEvents = $this->getAllEventsKeys();

        if (is_array($allEvents)) {
            $this->redis->del(self::EVENTS_NAME);

            return $this->redis->del($allEvents);
        }

        return false;
    }

    private function saveEventKey(string $key): void
    {
        $this->redis->sAdd(self::EVENTS_NAME, $key);
    }

    /**
     * @throws RedisException
     */
    private function getAllEventsKeys(): false|array|Redis
    {
        return $this->redis->sMembers(self::EVENTS_NAME);
    }
}
