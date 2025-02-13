<?php

declare(strict_types=1);

namespace App;

interface EventStorageInterface
{
    public function add(array $event): void;

    public function get(array $params): ?array;

    public function clear(): void;
}