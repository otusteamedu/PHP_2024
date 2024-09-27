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
            EventPropertyFactory::createFromArray($input['properties'] ?? []),
        );
    }

    /**
     * @param string $json
     * @return Event[]
     * @throws \JsonException
     */
    public static function createListFromJson(string $json): array
    {
        $inputs = json_decode(
            $json,
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        $result = [];
        foreach ($inputs as $input) {
            $result[] = new Event(
                $input['name'],
                $input['priority'],
                EventPropertyFactory::createFromArray($input['properties']),
            );
        }
        return $result;
    }
}
