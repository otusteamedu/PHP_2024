<?php

namespace AnatolyShilyaev\Hw11\Storage;

interface StorageInterface
{
    public function add(string $event, int $priority, string $value): void;

    public function clear(): void;

    public function findBestMatch(array $params): ?string;

    public function get(string $key): array;
}
