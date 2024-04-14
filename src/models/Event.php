<?php

namespace AKornienko\Php2024\models;

readonly class Event
{
    public string $name;
    public string $description;

    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public static function isValidPayload(array $payload): bool
    {
        if (!$payload['name'] || !$payload['description']) {
            return false;
        }
        return true;
    }
}
