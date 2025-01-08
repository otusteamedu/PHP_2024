<?php

namespace SergeyShirykalov\RedisEvents;

class EventManager
{
    public function __construct(private readonly EventStorageInterface $eventStorage)
    {
    }

    public function add(array $event): void
    {
        $this->eventStorage->add($event);
    }

    public function clear(): void
    {
        $this->eventStorage->clear();
    }

    public function get(array $filter): ?array
    {
        return $this->eventStorage->get($filter);
    }
}
