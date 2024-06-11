<?php

declare(strict_types=1);

namespace App\Application\EventSourcing;

class EventManager implements IEventPublisher
{
    private array $listeners = [];

    public function subscribe(string $eventType, IEventListener $eventListener): void
    {
        $this->listeners[$eventType][] = $eventListener;
    }

    public function unSubscribe(string $eventType, IEventListener $eventListener): void
    {
        if (!isset($this->listeners[$eventType])) {
            return;
        }

        $this->listeners[$eventType] = array_filter($this->listeners[$eventType], fn($obs) => $obs !== $eventListener);
    }

    public function notify(object $event): void
    {
        $eventType = $event::class;
        if (!isset($this->listeners[$eventType])) {
            return;
        }

        foreach ($this->listeners[$eventType] as $listener) {
            $listener->execute($event);
        }
    }
}
