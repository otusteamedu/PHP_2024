<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Interface\{EventInterface, PublisherInterface};

use function DI\get;

class EventManager implements PublisherInterface
{
    private array $subscribers = [];

    public function subscribe(string $event, string $listener): void
    {
        $this->subscribers[$event][] = $listener;
    }

    public function unsubscribe(string $event, string $listener): void
    {
        if (!isset($this->subscribers[$event])) {
            return;
        }

        $this->subscribers[$event] = array_filter(
            $this->subscribers[$event],
            static fn(string $value): bool => $value !== $listener
        );
    }

    public function notify(EventInterface $event): void
    {
        if (!isset($this->subscribers[get_class($event)])) {
            return;
        }

        foreach ($this->subscribers[get_class($event)] as $listenerClass) {
            $listener = get($listenerClass);
            $listener->handle($event);
        }
    }
}
