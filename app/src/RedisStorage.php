<?php

namespace Kagirova\Hw15;

use Redis;

class RedisStorage implements Storage
{
    const EVENTS_KEY = 'events';
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('redis');
    }

    public function set(Event $event): void
    {
        $response = $this->redis->zAdd(RedisStorage::EVENTS_KEY, $event->getPriority(),
            json_encode(['conditions' => $event->getConditions(), 'event' => $event->getName()]));
        echo 'Added ' . $response . " items \n";
    }

    public function get($conditions): ?Event
    {
        $events = $this->redis->zRevRangeByScore(RedisStorage::EVENTS_KEY, '+inf', '-inf', ['withscores' => true]);
        foreach ($events as $eventKey => $eventValue) {
            $eventData = json_decode($eventKey, true);
            $conditionsMet = true;
            foreach ($conditions as $key => $value) {
                if (!array_key_exists($key, $eventData)) {
                    $conditionsMet = false;
                    break;
                }
                if ($eventData[$key] != $value) {
                    $conditionsMet = false;
                    break;
                }
            }
            if ($conditionsMet) {
                return new Event($eventValue, $eventData['conditions'], $eventData['event']);
            }
        }
        return null;
    }

    public function clear(): void
    {
        $count = $this->redis->del(RedisStorage::EVENTS_KEY);
        echo 'Deleted ' . $count . " items \n";
    }
}
