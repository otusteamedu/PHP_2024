<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry;

use InvalidArgumentException;
use stdClass;

class EventEntity
{
    /** @var integer */
    public int $priority;
    /** @var array<string, mixed> */
    public array $conditions = [];
    /** @var string */
    public string $event;

    /**
     * @param stdClass $data
     */
    public function __construct(stdClass $data)
    {
        if (!property_exists($data, 'priority')) {
            throw new InvalidArgumentException('Priority was not defined');
        }
        $this->priority = (int) $data->priority;

        if (!property_exists($data, 'event')) {
            throw new InvalidArgumentException('Event was not defined');
        }
        $this->event = (string) $data->event;

        if (!property_exists($data, 'conditions')) {
            throw new InvalidArgumentException('Conditions were not defined');
        }
        $this->conditions = (array) $data->conditions;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return [
            'event' => $this->event,
            'conditions' => $this->conditions,
        ];
    }
}
