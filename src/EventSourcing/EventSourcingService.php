<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing;

use Alogachev\Homework\EventSourcing\Event\Event;
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
            new Event(
                $data['name'] ?? 'unexpected',
                    $data['description'] ?? []
            ),
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
    public function findTheMostSuitableEvent(array $data): void
    {
        $query = new SearchEventQuery($data['conditions'] ?? []);
        $storedEvent = $this->eventRepository->findTheMostSuitableEvent($query);
        $event = $storedEvent?->event();

        echo (isset($event) ? json_encode($event->toArray()) : 'Подходящего события не найдено') . PHP_EOL;
    }
}
