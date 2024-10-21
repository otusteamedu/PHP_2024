<?php

declare(strict_types=1);

namespace IraYu\Hw12\Domain\Entity;

class Event
{
    public function __construct(
        private string $name,
        private int $priority,
        private EventProperties $properties,
    ) {
    }

    public function getProperties(): EventProperties
    {
        return $this->properties;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
