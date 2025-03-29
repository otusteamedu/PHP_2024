<?php

declare(strict_types=1);

namespace Aware\App\Domain\Event;

use Exception;

class EventBuilder
{
    private int $priority = 0;
    private array $conditions = [];
    private array $event = [];

    public function withPriority(int $priority): self
    {
        $clone = clone $this;
        $clone->priority = $priority;
        return $clone;
    }

    public function addCondition(string $param, int $value): self
    {
        $clone = clone $this;
        $clone->conditions[$param] = $value;
        return $clone;
    }

    public function withEvent(array $eventData): self
    {
        $clone = clone $this;
        $clone->event = $eventData;
        return $clone;
    }

    /**
     * @throws Exception
     */
    public function build(): Event
    {
        if (empty($this->conditions)) {
            throw new Exception('Conditions cant be empty');
        }

        return new Event($this->priority, $this->conditions, $this->event);
    }

    public static function create(): self
    {
        return new self();
    }
}
