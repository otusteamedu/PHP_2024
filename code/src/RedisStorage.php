<?php

namespace SergeyShirykalov\RedisEvents;

class RedisStorage implements EventStorageInterface
{
    private \Redis $redis;

    /**
     * @throws \RedisException
     */
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('redis', 6379);
    }

    /**
     * @throws \RedisException
     */
    public function add(array $event): void
    {
        $priority = $event['priority'] ?? 0;
        $this->redis->zAdd('events', $priority, json_encode($event));
    }

    public function get(array $params): ?array
    {
        // выберем все события в порядке убывания приоритета
        $events = $this->redis->zRevRangeByScore('events', '+inf', '-inf');
        $res = null;
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
                // Если совпали все условия, то берем текущий элемент как результат и цикл прерываем,
                // т.к. у нас множество упорядочено по убыванию приоритета
               $res = $event;
               break;
            }
        }
        return $res;
    }

    /**
     * @throws \RedisException
     */
    public function clear(): void
    {
        $this->redis->del('events');
    }
}
