<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing;

use Alogachev\Homework\EventSourcing\Event\EventType;
use Alogachev\Homework\EventSourcing\Event\SearchEventQuery;
use Alogachev\Homework\EventSourcing\Event\StoredEvent;
use RedisException;

class EventSourcingService
{
    public function __construct(
        private readonly RedisEventRepository $eventRepository,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function addEvent(array $data): void
    {
        $event = new StoredEvent(
            $data['priority'] ?? 0,
            $data['conditions'] ?? [],
            new EventType($data['name'] ?? 'unexpected'),
        );

        $this->eventRepository->addEvent($event);
    }

    /**
     * @throws RedisException
     */
    public function clearEvents(): void
    {
        $this->eventRepository->clearEvents();
    }

    /**
     * @throws RedisException
     */
    public function findTheMostSuitableEvent(array $data): array
    {
        $query = new SearchEventQuery($data['conditions'] ?? []);
        $event = $this->eventRepository->findTheMostSuitableEvent($query);

        return [];
    }
}
