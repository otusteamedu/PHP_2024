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
            'properties' => array_merge(...array_map(
                fn(Domain\Entity\EventProperty $property) => [
                    $property->getName() => $property->getValue(),
                ],
                $event->getProperties()->jsonSerialize()
            ))
        ];

        return json_encode($res, JSON_THROW_ON_ERROR);
    }
}
