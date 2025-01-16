<?php

namespace App\Storages;

interface EventStorageInterface
{
    public function add(string $key, int $score, string $value): false|int;

    public function delete(string $key): false|int;

    public function rangeByScore(string $key, string $min, string $max): ?array;
}
