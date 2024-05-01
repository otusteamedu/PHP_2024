<?php

declare(strict_types=1);

namespace AShutov\Hw15;

use AShutov\Hw15\Requests\AddEventRequest;

interface StorageClientInterface
{
    public function addEvent(string $key, AddEventRequest $value): int|false;

    public function getEvent(string $key): array;

    public function removeAllEvents(): false|int;
}
