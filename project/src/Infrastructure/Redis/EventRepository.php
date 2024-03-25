<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Redis;

use Predis\Client;
use SFadeev\Hw12\Domain\Entity\Event;
use SFadeev\Hw12\Domain\Repository\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    private const KEY = 'event';

    public function __construct(
        private Client $client
    )
    {
    }

    public function save(Event $event): Event
    {
        var_dump(json_encode($event, JSON_THROW_ON_ERROR));
        $this->client->zadd(self::KEY, [json_encode($event, JSON_THROW_ON_ERROR) => $event->getPriority()]);

        return $event;
    }

    public function clear(): void
    {
        $this->client->flushdb();
    }

    public function findAllWithPriorityOrder(): array
    {
        $rawEvents = $this->client->zrevrange(self::KEY, 0, -1);

        $events = [];

        foreach ($rawEvents as $rawEvent) {
            $events[] = Event::fromJson($rawEvent);
        }

         return $events;
    }
}
