<?php

declare(strict_types=1);

namespace AShutov\Hw15\Models;

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
