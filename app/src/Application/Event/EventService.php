<?php

declare(strict_types=1);

namespace Aware\App\Application\Event;

use Aware\App\Domain\Event\Event;
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
        $event = Event::decode($event);
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
