<?php

declare(strict_types=1);

namespace App\Analytics\Factory;

use App\Analytics\Model\EventCondition;

final readonly class EventConditionFactory
{
    public function make(string $key, string $value): EventCondition
    {
        return new EventCondition($key, $value);
    }

    /**
     * @param array{key: string, value: string} $data
     *
     * @return EventCondition
     */
    public function makeFromArray(array $data): EventCondition
    {
        return $this->make($data['key'], $data['value']);
    }
}
