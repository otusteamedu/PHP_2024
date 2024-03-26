<?php

namespace AleksandrOrlov\Php2024\Storage;

interface Base
{
    public function add(int $priority, array $conditions, string $event): void;
    public function clear(): void;
    public function get($params): ?string;
}
