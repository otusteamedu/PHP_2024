<?php

namespace App\Storage;

use App\Client\RedisClient;
use App\Model\Event;

class RedisStorage implements Storage
{
    private RedisClient $client;

    public function __construct()
    {
        $this->client = new RedisClient();
    }

    public function migrate(array $events): void
    {
        /** @var Event[] $event */
        foreach ($events as $event) {
            foreach ($event->conditions as $conditionKey => $conditionValue) {
                $this->client->zAdd($conditionKey . ':' . $conditionValue, $event->priority, json_encode($event));
            }
        }
    }

    public function addEvent(Event $event): void
    {
        foreach ($event->conditions as $conditionKey => $conditionValue) {
            $this->client->zAdd($conditionKey . ':' . $conditionValue, $event->priority, json_encode($event));
        }
    }

    public function getBestEvent(array $userConditions): ?Event
    {
        $bestEvent = null;

        $params = $userConditions['params'];

        foreach ($params as $conditionKey => $conditionValue) {
            $eventsByCondition = $this->client->zRevRange($conditionKey . ':' . $conditionValue, 0, -1);

            foreach ($eventsByCondition as $json) {
                $event = Event::decode($json);

                if ($event->hasAllConditions($params) && $event->isBetterThanLast($bestEvent)) {
                    $bestEvent = $event;
                    break;
                }
            }
        }

        return $bestEvent;
    }

    public function deleteAll(): void
    {
        $this->client->deleteAll();
    }
}