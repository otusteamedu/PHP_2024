<?php

declare(strict_types=1);

namespace hw15;

class Event
{
    public function __construct(
        public int $priority,
        public array $conditions,
        public string $event
    ) {
    }
}
