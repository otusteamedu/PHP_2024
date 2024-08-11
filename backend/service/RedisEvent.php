<?php

namespace Service;

class RedisEvent
{
    public function __construct(private readonly \Redis $redis)
    {
    }

    public function addEvent($priority, $conditions, $event)
    {
        $eventData = [
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event,
        ];
        $this->redis->zAdd('events', $priority, json_encode($eventData));
    }

    public function clearEvents()
    {
        $this->redis->del('events');
    }

    public function getBestMatchingEvent($params)
    {
        $events = $this->redis->zRangeByScore('events', 0, PHP_INT_MAX);
        $bestEvent = null;
        try {
            foreach ($events as $eventData) {
                $event = json_decode($eventData, true, 512, JSON_THROW_ON_ERROR);
                if ($this->matchConditions($event['conditions'], $params)) {
                    if ($bestEvent === null || $event['priority'] > $bestEvent['priority']) {
                        $bestEvent = $event;
                    }
                }
            }
        } catch (\JsonException $e) {
            throw new \Exception("Failed to decode event data: " . $e->getMessage());
        }
        return $bestEvent;
    }

    private function matchConditions($conditions, $params)
    {
        foreach ($conditions as $key => $value) {
            if (!array_key_exists($key, $params) || $params[$key] !== $value) {
                return false;
            }
        }
        return true;
    }
}
