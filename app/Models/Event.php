<?php

namespace App\Models;

/**
 * Event pseudo-model.
 */
class Event
{
    /**
     * @var int Event priority.
     */
    public int $priority;

    /**
     * @var array<string, int> Event conditions.
     */
    public array $conditions;

    /**
     * @var string Event info.
     */
    public string $event;

    /**
     * Creates an Event instance based on json.
     *
     * @param string $json Json encoded string.
     * @return static Freshly created instance.
     */
    public static function createFromJson(string $json): static
    {
        return new static(); // todo: from constructor
    }
}