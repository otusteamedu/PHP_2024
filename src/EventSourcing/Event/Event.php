<?php

declare(strict_types=1);

namespace Alogachev\Homework\EventSourcing\Event;

class Event
{
    public function __construct(
        private readonly string $name,
        private readonly string $description = '',
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
