<?php

namespace AKornienko\Php2024\Application;

use AKornienko\Php2024\Domain\Event;

abstract class StorageClient
{
    abstract public function addEvent(string $key, int $priority, Event $event): int|false;

    abstract public function getEvent(string $key): array;

    abstract public function removeAllEvents(): false|int;
}
