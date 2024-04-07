<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing\Event;

class StoredEvent
{
    public function __construct(
        private readonly string $priority,
        /**
         * @var string[] $conditions
         */
        private readonly array  $conditions,
        private readonly Event  $event,
    ) {
    }

    public function priority(): string
    {
        return $this->priority;
    }

    public function conditions(): array
    {
        return $this->conditions;
    }

    public function event(): Event
    {
        return $this->event;
    }
}
