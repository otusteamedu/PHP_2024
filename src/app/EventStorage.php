<?php

declare(strict_types=1);

namespace App;

use App\Storages\EventStorageInterface;

readonly class EventStorage
{
    public const KEY_NAME = 'events';

    public function __construct(private EventStorageInterface $storage)
    {
        //
    }

    public function addEvent(int $priority, array $conditions, string $event): void
    {
        $this->storage->add(self::KEY_NAME, $priority, json_encode([
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event
        ]));
    }

    public function clearEvents(): void
    {
        $this->storage->delete(self::KEY_NAME);
    }

    public function getEventByParams(array $params): ?array
    {
        $events = $this->storage->rangeByScore(self::KEY_NAME, '-inf', '+inf');

        usort($events, static fn($a, $b) => $b['priority'] <=> $a['priority']);

        foreach ($events as $event) {
            if ($this->matchConditions($event['conditions'], $params)) {
                return $event;
            }
        }

        return null;
    }

    private function matchConditions(array $conditions, array $params): bool
    {
        foreach ($conditions as $key => $value) {
            if (!isset($params[$key]) || $params[$key] != $value) {
                return false;
            }
        }

        return true;
    }
}
