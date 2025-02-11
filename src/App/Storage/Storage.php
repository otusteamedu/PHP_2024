<?php

namespace App\Storage;

use App\Model\Event;

interface Storage
{
    /**
     * @param Event[] $events
     * @return void
     */
    public function migrate(array $events): void;

    /**
     * @param Event $event
     * @return bool
     */
    public function addEvent(Event $event): void;

    /**
     * @param array $userConditions
     * @return Event|null
     */
    public function getBestEvent(array $userConditions): ?Event;

    /**
     * @return void
     */
    public function deleteAll(): void;
}