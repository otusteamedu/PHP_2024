<?php

declare(strict_types=1);

namespace IraYu\Hw12\Application\Event;

use IraYu\Hw12\Domain\Entity\Event;
use IraYu\Hw12\Domain\Entity\EventProperties;
use IraYu\Hw12\Domain\Entity\EventProperty;

class EventPropertyFactory
{
    /**
     * @param string $json
     * @return EventProperty[]
     * @throws \JsonException
     */
    public static function createListFromJson(string $json): array
    {
        $input = json_decode(
            $json,
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        $properties = [];
        foreach ($input['properties'] as $propertyName => $propertyValue) {
            $properties[] = new EventProperty(
                $propertyName,
                $propertyValue,
            );
        }

        return $properties;
    }

    /**
     * @param string $json
     * @return EventProperties
     * @throws \JsonException
     */
    public static function createFromArray(array $input): EventProperties
    {
        $properties = new EventProperties();
        foreach ($input as $propertyName => $propertyValue) {
            $properties[] = new EventProperty(
                $propertyName,
                $propertyValue,
            );
        }

        return $properties;
    }
}
