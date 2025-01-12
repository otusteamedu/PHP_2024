<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Storages\RedisDb;

use Asyrovatkin\Hw11\Models\Event;
use Asyrovatkin\Hw11\Storages\Storage;
use Predis\Client;


class RedisDb implements Storage
{
    const ID_COUNTER = 'id_counter';
    const EVENTS = 'events';
    const PRIORITIES = 'priorities';
    const PRIORITY = 'priority';
    const PARAM1 = 'param1';
    const PARAM2 = 'param2';

    private Client $client;
    public function __construct()
    {
        $this->client = new Client('tcp://redis:6379');
        $this->client->connect();
        if (is_null($this->client->get(self::ID_COUNTER))) $this->client->set(self::ID_COUNTER, 0);
    }

    public function addEvent(Event $event)
    {
        $eventName = $event->getEvent();
        $priority = $event->getPriority();
        $param1 = $event->getParam1();
        $param2 = $event->getParam2();

        $id = $this->client->get(self::ID_COUNTER);
        $id++;
        $this->client->multi();
        $this->addEventName($id, $eventName);
        if (!is_null($priority)) $this->addEventPriority($id, $priority);
        if (!is_null($param1)) $this->addEventParam1($id, (string)$param1);
        if (!is_null($param2)) $this->addEventParam2($id, (string)$param2);
        $this->client->exec();

        return $id;
    }

    private function addEventName($id, string $eventName): void
    {
        $this->client->hset(self::EVENTS, $id, $eventName );
        $this->client->set(self::ID_COUNTER, $id);
    }

    private function addEventPriority(int $eventId, int $priority): void
    {
        $this->client->sadd(self::PRIORITIES, [$priority]);
        $this->client->sadd(self::PRIORITY . ':' . $priority, [$eventId]);
    }

    private function addEventParam1(int $eventId, string $param): void
    {
        $this->client->sadd(self::PARAM1 . ':' . $param, [$eventId]);
    }
    private function addEventParam2(int $eventId, string $param): void
    {
        $this->client->sadd(self::PARAM2 . ':' . $param, [$eventId]);
    }

    public function getEventIdsByParamsWithMaxPriority(array $params): array
    {
        $keys = $this->getParamsKeys($params);
        $sortedPriorities = $this->getSortedPriorities();

        foreach ($sortedPriorities as $priority) {
            $priorityKey = self::PRIORITY . ':' . $priority;
            $result = $this->client->sinter(array_merge($keys, [$priorityKey]));
            if (!empty(reset($result))) {
                return $this->getEventsByIds($result);
            }
        }

        return [];
    }

    private function getParamsKeys(array $params): array
    {
        $keys = [];
        foreach ($params as $key => $value) {
            $keys[] = $key . ':' . $value;
        }
        return $keys;
    }

    private function getSortedPriorities(): array
    {
        $priorities = $this->client->smembers(self::PRIORITIES);
        rsort($priorities, SORT_NUMERIC);
        return $priorities;
    }

    private function getEventsByIds(array $eventsIds): array
    {
        $eventsNames = [];
        foreach ($eventsIds as $eventId) {
            $eventName = $this->client->hget(self::EVENTS, $eventId);
            if (!is_null($eventName)) $eventsNames[] = $eventName . ' for id = ' . $eventId;
        }
        return $eventsNames;
    }

    public function clearStorage(): void
    {
        $this->client->flushall();
    }
}