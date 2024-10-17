<?php

declare(strict_types=1);

namespace App\Analytics\Utility;

use App\Analytics\Model\Event;

final readonly class EventFormatter
{
    private EventConditionFormatter $eventConditionFormatter;

    public function __construct()
    {
        $this->eventConditionFormatter = new EventConditionFormatter();
    }

    /**
     * @param Event ...$events
     *
     * @return array{headers: string[], rows: array<array-key, array<array-key, string | int | float>>}
     */
    public function toTable(Event ...$events): array
    {
        $headers = array_map('ucfirst', array_keys(current($events)->toArray()));

        $rows = [];

        foreach ($events as $event) {
            $data = $event->toArray();

            $data['conditions'] = $this->eventConditionFormatter->toList(...$event->conditions->all());

            $rows[] = array_values($data);
        }

        return ['headers' => $headers, 'rows' => $rows];
    }
}
