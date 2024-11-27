<?php

namespace App\Storage;

interface StorageInterface
{
    public function save(string $key, array $data): void;

    public function get(string $key): ?array;

    public function getAll(string $pattern): array;

    public function delete(string $key): void;

    public function clear(string $pattern): void;
}