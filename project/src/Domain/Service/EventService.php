<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Service;

use SFadeev\Hw12\Domain\Entity\Event;
use SFadeev\Hw12\Domain\Exception\EventNotFoundException;
use SFadeev\Hw12\Domain\Repository\EventRepositoryInterface;

class EventService
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private ConditionService $conditionService,
    )
    {
    }

    public function save(Event $event): Event
    {
        return $this->eventRepository->save($event);
    }

    public function clear(): void
    {
        $this->eventRepository->clear();
    }

    public function findRelevant(array $params): Event
    {
        $events = $this->eventRepository->findAllWithPriorityOrder();

        $filtered = [];

        foreach ($events as $event) {
            if ($this->conditionService->match($event->getCondition(), $params)) {
                $filtered[] = $event;
            }
        }

        if (count($filtered) === 0) {
            throw new EventNotFoundException();
        }

        return $filtered[0];
    }
}
