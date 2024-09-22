<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\Event;

use IraYu\Hw12\Domain;

class EventSerializer
{
    public static function toJson(Domain\Entity\Event $event): string
    {
        return json_encode([
            'priority' => $event->getPriority(),
            'name' => $event->getName(),
            'params' => $event->getProperties(),
        ]);
    }
}
