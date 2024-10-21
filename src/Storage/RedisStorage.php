<?php

namespace Komarov\Hw11\Storage;

use Komarov\Hw11\Interface\EventStorageInterface;
use Predis\Client;

class RedisStorage implements EventStorageInterface
{
    private Client $redis;

    public function __construct(string $host = '127.0.0.1', int $port = 6379)
    {
        $this->redis = new Client([
            'host' => $host,
            'port' => $port,
        ]);
    }

    /**
     * @param array $event
     * @return int
     */
    public function addEvent(array $event): int
    {
        $eventId = $this->redis->incr('event_id');
        $this->redis->hset("event:$eventId", 'priority', $event['priority']);

        foreach ($event['conditions'] as $param => $value) {
            $this->redis->hset("event:$eventId", "condition:$param", $value);
        }

        $this->redis->hset("event:$eventId", 'event', json_encode($event['event']));

        return $eventId;
    }

    /**
     * @return void
     */
    public function clearEvents(): void
    {
        $keys = $this->redis->keys('event:*');

        if (!empty($keys)) {
            $this->redis->del($keys);
        }

        $this->redis->del('event_id');
    }

    public function getBestEvent(array $params)
    {
        $events = $this->redis->keys('event:*');
        $bestEvent = null;
        $highestPriority = -1;

        foreach ($events as $eventKey) {
            $eventData = $this->redis->hgetall($eventKey);
            $isMatch = true;

            foreach ($params as $param => $value) {
                if ($eventData["condition:$param"] != $value) {
                    $isMatch = false;
                    break;
                }
            }

            if ($isMatch && $eventData['priority'] > $highestPriority) {
                $highestPriority = $eventData['priority'];
                $bestEvent = json_decode($eventData['event'], true);
            }
        }

        return $bestEvent;
    }
}
