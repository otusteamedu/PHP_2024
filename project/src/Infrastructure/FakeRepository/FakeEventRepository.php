<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\FakeRepository;

use SFadeev\Hw12\Domain\Entity\Event;
use SFadeev\Hw12\Domain\Repository\EventRepositoryInterface;

class FakeEventRepository implements EventRepositoryInterface
{
    private array $events;

    public function __construct()
    {
        $this->events = [
            new Event(100, 'name = 1', '{::event1::}'),
            new Event(50, 'name = 3', '{::event2::}'),
            new Event(40, 'name = 5', '{::event3::}'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function save(Event $event): Event
    {
        $this->events[] = $event;

        return $event;
    }

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        $this->events = [];
    }

    /**
     * @inheritDoc
     */
    public function findAllWithPriorityOrder(): array
    {
        usort($this->events, fn(Event $a, Event $b) => $a->getPriority() <=> $b->getPriority());

        return $this->events;
    }
}
