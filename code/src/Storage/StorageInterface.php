<?php

namespace Otus\App\Storage;

interface StorageInterface
{
    public function add(string $key, string $priority, string $value): bool;

    public function get(string $key, string $searchParams): string;

    public function clear(string $key): bool;
}
