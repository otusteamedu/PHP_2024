<?php

namespace App\Models;

use JsonException;

/**
 * Event pseudo-model.
 */
class Event
{
    /**
     * @param int $id Unique id.
     * @param int $priority Event priority.
     * @param array<string, int> $conditions Event conditions.
     * @param string $event Event info.
     * @throws JsonException If json fails.
     */
    public function __construct(
        public int $id,
        public int $priority,
        public array|string $conditions,
        public string $event
    ) {
        if (is_string($this->conditions)) {
            $this->conditions = json_decode($this->conditions, true, flags: JSON_THROW_ON_ERROR);
        }
    }

    /**
     * Creates an Event instance based on json.
     *
     * @param array $json Json encoded string.
     * @return static Freshly created instance.
     * @throws JsonException If json fails.
     */
    public static function instance(array $json): static
    {
        return new static(...$json);
    }
}
