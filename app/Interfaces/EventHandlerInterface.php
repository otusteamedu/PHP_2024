<?php

namespace App\Interfaces;

use App\Models\Event;
use Generator;

/**
 * Interface for the event handlers.
 */
interface EventHandlerInterface
{
    /**
     * Add new event and store it.
     *
     * @param array $fields
     * @return Event
     */
    public function add(array $fields): Event;

    /**
     * Find events with optional conditions.
     *
     * @param array<string, int> $conditions
     * @return Generator
     */
    public function find(array $conditions = []): Generator;

    /**
     * Remove all events from the storage.
     *
     * @return bool
     */
    public function flush(): bool;
}
