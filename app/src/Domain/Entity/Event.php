<?php

namespace Kagirova\Hw15\Domain\Entity;

class Event
{
    private string $name;
    private int $priority;
    private array $conditions;

    public function __construct(int $priority, array $conditions, string $name)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->conditions = $conditions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function print()
    {
        echo "Event: " . $this->name . "\n";
        echo "Priority: " . $this->priority . "\n";
        echo "Conditions: " . var_dump($this->conditions) . "\n";
    }
}
