<?php

declare(strict_types=1);

namespace App\Analytics\Factory;

use App\Analytics\Model\EventCondition;
use App\Analytics\Model\EventConditions;

final readonly class EventConditionsFactory
{
    private EventConditionFactory $eventConditionFactory;

    public function __construct()
    {
        $this->eventConditionFactory = new EventConditionFactory();
    }

    public function make(EventCondition ...$conditions): EventConditions
    {
        return new EventConditions($conditions);
    }

    /**
     * @param array<array-key, array{key: string, value: string}> $data
     *
     * @return EventConditions
     */
    public function makeFromArray(array $data): EventConditions
    {
        $conditions = [];

        foreach ($data as $condition) {
            $conditions[] = $this->eventConditionFactory->makeFromArray($condition);
        }

        return $this->make(...$conditions);
    }
}
