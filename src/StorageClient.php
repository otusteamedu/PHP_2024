<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\requests\AddEventRequest;

abstract class StorageClient
{
    abstract public function addEvent(string $key, AddEventRequest $value): int|false;

    abstract public function getEvent(string $key): array;

    abstract public function removeAllEvents(): false|int;
}
