<?php

declare(strict_types=1);

namespace App\Analytics\Model;

final readonly class Event
{
    public function __construct(
        public string $name,
        public EventConditions $conditions,
        public int | float $priority = 0,
    ) {}

    public function matches(EventCondition ...$conditions): bool
    {
        return $this->conditions->matches(...$conditions);
    }

    /**
     * @return array{name: string, priority: int | float, conditions: array<array-key, array{key: string, value: string}>}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'conditions' => $this->conditions->toArray(),
            'priority' => $this->priority,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
