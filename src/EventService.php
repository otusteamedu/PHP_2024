<?php

namespace Ahar\Hw12;

use Ahar\Hw12\storage\Storage;

class EventService
{
    public function __construct(
        private readonly Storage $storage,
    )
    {
    }

    public function addEvent(string $key, Event $event): void
    {
        $this->storage->add($key, $event);
    }

    public function getEvent(string $key, array $condition): ?Event
    {
        $events = $this->storage->get($key);
        if (empty($events)) {
            return null;
        }

        foreach ($events as $event) {
            if ($this->conditionsMatch($event->conditions, $condition)) {
                return $event;
            }
        }

        return null;
    }

    private function conditionsMatch($eventConditions, $userParams): bool
    {
        foreach ($eventConditions as $param => $value) {
            if (!isset($userParams[$param]) || $userParams[$param] !== $value) {
                return false;
            }
        }

        return true;
    }

    public function clear(string $key): void
    {
        $this->storage->clear($key);
    }
}
