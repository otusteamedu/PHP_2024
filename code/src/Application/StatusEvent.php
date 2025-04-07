<?php

declare(strict_types=1);

namespace Irayu\Hw16\Application;

class StatusEvent implements ObserverEvent
{
    public function __construct(private string $eventName)
    {
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }
}
