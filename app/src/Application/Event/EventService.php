<?php

declare(strict_types=1);

namespace Aware\App\Application\Event;

use Aware\App\Domain\Event\Event;
use Aware\App\Domain\Event\EventBuilder;
use Aware\App\Domain\Event\EventRepositoryInterface;
use Exception;

readonly class EventService
{
    public function __construct(
        private EventRepositoryInterface $eventRepository
    ) {
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

        $this->eventRepository->addEvent($event);
    }

    public function deleteEvents(): void
    {
        $this->eventRepository->deleteEvents();
    }

    public function getBestEvent($conditions): Event
    {
        return $this->eventRepository->getBestEvent($conditions);
    }
}
