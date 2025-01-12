<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Storages;

use Asyrovatkin\Hw11\Models\Event;

interface Storage
{
    public function addEvent(Event $event);

    public function getEventIdsByParamsWithMaxPriority(array $params): array;

    public function clearStorage(): void;
}