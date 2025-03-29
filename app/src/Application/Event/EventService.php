<?php

declare(strict_types=1);

namespace Aware\App\Application\Event;

use Aware\App\Domain\Event\Event;
use Aware\App\Domain\Event\EventBuilder;
use Aware\App\Domain\Event\EventRepositoryInterface;
use Exception;

class EventService
{
    private EventRepositoryInterface $repository;
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->repository = $eventRepository;
    }

    /**
     * @throws Exception
     */
    public function addEvent($event): void
    {
        $eventBuilder = EventBuilder::create();

        if ($event['priority'] > 0) {
            $eventBuilder = $eventBuilder->withPriority($event['priority']);
        }

        foreach ($event['conditions'] as $key => $value) {
            $eventBuilder = $eventBuilder->addCondition($key, (int) $value);
        }

        if (is_array($event['events'])) {
            $eventBuilder = $eventBuilder->withEvent($event['events']);
        }

        $event = $eventBuilder->build();

        $this->repository->addEvent($event);
    }

    public function deleteEvents(): void
    {
        $this->repository->deleteEvents();
    }

    public function getBestEvent($conditions): Event
    {
        return $this->repository->getBestEvent($conditions);
    }
}
