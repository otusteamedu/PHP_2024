<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Entity;

class Event
{
    public function __construct(
        private readonly string $id,
        private readonly int $priority,
        private readonly array $conditions,
        private readonly string $value
    ) {
    }

    public function getId(): string
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

    public function getValue(): string
    {
        return $this->value;
    }

    public function meetConditions(array $conditions): bool
    {
        foreach ($this->conditions as $name => $value) {
            if (!array_key_exists($name, $conditions)) {
                return false;
            }

            if ($conditions[$name] !== $value) {
                return false;
            }
        }

        return true;
    }
}
