<?php

declare(strict_types=1);

namespace IraYu\Hw12\Infrastructure\Repository\Redis;

use IraYu\Hw12\Application;
use IraYu\Hw12\Domain;
use IraYu\Hw12\Domain\Repository\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    private const KEY = 'event';

    public function __construct(
        private \Redis $client
    ) {
    }

    public function save(Domain\Entity\Event $event): Domain\Entity\Event
    {
        foreach ($event->getProperties() as $property) {
            $names = $this->client->hGet(
                self::KEY . '_prop_' . $property->getName(),
                $property->getValue()
            );
            $this->client->hSet(
                self::KEY . '_prop_' . $property->getName(),
                $property->getValue(),
                ($names ? $names . ',' : '') . $event->getName(),
            );
        }

        $this->client->zadd(
            self::KEY . '_priority',
            $event->getPriority(),
            Application\Event\EventSerializer::toJson($event)
        );

        return $event;
    }

    public function clear(): void
    {
        $this->client->flushDB();
    }

    /**
     * @param Domain\Entity\EventProperty[] $properties
     * @return array
     * @throws \JsonException
     * @throws \RedisException
     */
    public function findByProperties(array $properties): array
    {
        $eventNames = [];
        foreach ($properties as $property) {
            if ($nameList = $this->client->hGet(self::KEY . '_prop_' . $property->getName(), $property->getValue())) {
                $eventNames[] = explode(',', $nameList);
            }
        }
        $resultNames = array_intersect(...$eventNames);
        $rawEvents = $this->client->zRevRange(self::KEY . '_priority', 0, -1);

        $events = [];

        foreach ($rawEvents as $rawEvent) {
            $event = Application\Event\EventFactory::createFromJson($rawEvent);
            if (in_array($event->getName(), $resultNames, true)) {
                $events[] = $event;
            }
        }

        return $events;
    }
}
