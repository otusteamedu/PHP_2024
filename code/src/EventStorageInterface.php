<?php

namespace SergeyShirykalov\RedisEvents;

interface EventStorageInterface
{
    public function add(array $event): void;
    public function get(array $params): ?array;
    public function clear(): void;
}
