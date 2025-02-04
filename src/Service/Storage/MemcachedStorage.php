<?php

namespace KRudenko\Otus\Service\Storage;

use Memcached;

class MemcachedStorage implements StorageInterface
{
    private Memcached $memcached;
    private string $sortedEventsKey = 'events_sorted';
    private string $idCounterKey = 'event_id';

    public function __construct()
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer($_ENV['MEMCACHED_HOST'], $_ENV['MEMCACHED_PORT']);
    }

    public function addEvent(array $event): int
    {
        $id = $this->memcached->increment($this->idCounterKey, 1, 1);
        $key = "event:$id";

        // Сохраняем событие
        $this->memcached->set($key, json_encode([
            'priority' => $event['priority'],
            'conditions' => $event['conditions'],
            'event' => $event['event']
        ]));

        // Обновляем отсортированный список
        $sorted = $this->getSortedEvents();
        $sorted[$id] = $event['priority'];
        arsort($sorted);
        $this->memcached->set($this->sortedEventsKey, json_encode(array_keys($sorted)));

        return $id;
    }

    public function clearEvents(): void
    {
        $keys = [];
        foreach ($this->getAllEventKeys() as $id) {
            $keys[] = "event:$id";
        }
        $this->memcached->deleteMulti($keys);
        $this->memcached->delete($this->sortedEventsKey);
        $this->memcached->delete($this->idCounterKey);
    }

    public function getAllEventsSortedByPriority(): array
    {
        return $this->getSortedEvents();
    }

    public function getEventData(int $id): array
    {
        $data = json_decode($this->memcached->get("event:$id"), true);
        return [
            'conditions' => $data['conditions'],
            'event' => $data['event'],
            'priority' => $data['priority']
        ];
    }

    private function getSortedEvents(): array
    {
        $sorted = json_decode($this->memcached->get($this->sortedEventsKey), true) ?? [];
        return array_filter($sorted, fn($id) => $this->memcached->get("event:$id") !== false);
    }

    private function getAllEventKeys(): array
    {
        return $this->getSortedEvents();
    }
}
