<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\Event;

use IraYu\Hw12\Domain\Entity\Event;

class EventFactory
{
    public static function createFromJson(string $json): Event
    {
        $input = json_decode(
            $json,
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        return new Event(
            $input['name'],
            $input['priority'],
            $input['properties'],
        );
    }
}
