<?php

declare(strict_types=1);

namespace App\Analytics\Model;

final readonly class EventConditions
{
    public function __construct(
        public array $conditions = [],
    ) {}

    /**
     * @return EventCondition[]
     */
    public function all(): array
    {
        return $this->conditions;
    }

    public function matches(EventCondition ...$conditions): bool
    {
        foreach ($conditions as $passedCondition) {
            $hits = array_filter($this->all(), static function (EventCondition $condition) use ($passedCondition) {
                return $condition->matches($passedCondition);
            });

            if (!empty($hits)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<array-key, array{key: string, value: string}>
     */
    public function toArray(): array
    {
        return array_map(static fn(EventCondition $condition) => $condition->toArray(), $this->all());
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
