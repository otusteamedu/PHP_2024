<?php

namespace App\Interfaces;

use App\Models\Event;

/**
 * Interface for the event handlers.
 */
interface EventHandlerInterface
{
    /**
     * Add new event and store it.
     *
     * @param string $fields
     * @return Event
     */
    public function add(string $fields): Event;

    /**
     * Find events with optional conditions.
     *
     * @param array|null $conditions
     * @return array<int, Event>
     */
    public function find(?array $conditions = null): array;

    /**
     * Remove all events from the storage.
     *
     * @return bool
     */
    public function flush(): bool;
}
