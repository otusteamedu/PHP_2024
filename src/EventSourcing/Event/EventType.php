<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing\Event;

class EventType
{
    public function __construct(
        private readonly string $name,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }
}
