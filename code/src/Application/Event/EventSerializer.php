<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\Event;

use IraYu\Hw12\Domain;

class EventSerializer
{
    public static function toJson(Domain\Entity\Event $event): string
    {
        $res = [
            'name' => $event->getName(),
            'priority' => $event->getPriority(),
            'properties' => $event->getProperties()->jsonSerialize(),
        ];

        return json_encode($res, JSON_THROW_ON_ERROR);
    }
}
