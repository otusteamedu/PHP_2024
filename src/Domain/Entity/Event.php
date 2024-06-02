<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Event
{
    public function __construct(private string $event, private int $priority, private array $condition)
    {
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getCondition(): array
    {
        return $this->condition;
    }
}
