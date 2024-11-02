<?php

namespace VSukhov\Hw11\Redis;

use Predis\Client;
use VSukhov\Hw11\App\EventStorageInterface;

class Storage implements EventStorageInterface
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
    public function add(array $event): int
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
    public function clear(): void
    {
        $keys = $this->redis->keys('event:*');

        if (!empty($keys)) {
            $this->redis->del($keys);
        }

        $this->redis->del('event_id');
    }

    public function getBest(array $params)
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
