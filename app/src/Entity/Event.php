<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Entity;

readonly class Event
{
    private \stdClass $event;

    public function __construct(
        private int $id,
        private int $priority,
        private array $conditions,
        string $content,
    ) {
        $this->event = (object) [ 'content' => $content ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getEvent(): \stdClass
    {
        return $this->event;
    }

    public function __toString(): string
    {
        return sprintf(
            'ID: %d, Priority: %d, , Content: %s, Conditions: %s',
            $this->id,
            $this->priority,
            $this->event->content,
            print_r($this->conditions, true)
        );
    }
}
