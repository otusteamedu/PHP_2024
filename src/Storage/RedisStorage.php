<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Storage;

use Redis;
use RedisException;

class RedisStorage implements Base
{
    private Redis $redis;

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    /**
     * @throws RedisException
     */
    public function add(int $priority, array $conditions, string $event): void
    {
        $this->redis->zAdd('events', $priority, json_encode(['conditions' => $conditions, 'event' => $event]));
    }

    /**
     * @throws RedisException
     */
    public function clear(): void
    {
        $this->redis->del('events');
    }

    /**
     * @throws RedisException
     */
    public function get($params): ?string
    {
        $events = $this->redis->zRevRange('events', 0, -1);

        foreach ($events as $event) {
            $eventData = json_decode($event, true);
            $conditionsMet = true;

            foreach ($eventData['conditions'] as $key => $value) {
                if (!isset($params[$key]) || $params[$key] != $value) {
                    $conditionsMet = false;
                    break;
                }
            }

            if ($conditionsMet) {
                return $eventData['event'];
            }
        }

        return null;
    }
}
