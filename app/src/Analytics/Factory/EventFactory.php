<?php

declare(strict_types=1);

namespace App\Analytics\Factory;

use App\Analytics\Model\Event;
use App\Analytics\Model\EventConditions;

final readonly class EventFactory
{
    private EventConditionsFactory $eventConditionsFactory;

    public function __construct()
    {
        $this->eventConditionsFactory = new EventConditionsFactory();
    }

    public function make(string $name, EventConditions $conditions, int | float $priority): Event
    {
        return new Event($name, $conditions, $priority);
    }

    /**
     * @param array{name: string, conditions: array<array-key, array<string, string>>, priority: int | float} $data
     *
     * @return Event
     */
    public function makeFromArray(array $data): Event
    {
        $conditions = $this->eventConditionsFactory->makeFromArray($data['conditions']);

        return $this->make($data['name'], $conditions, $data['priority']);
    }

    public function makeFromJson(string $json): Event
    {
        return $this->makeFromArray(json_decode($json, true));
    }
}
