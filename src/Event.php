<?php

namespace Ahar\Hw12;

class Event
{
    public const string KEY_EVENT = 'event';

    public function __construct(
        public readonly int    $priority,
        public readonly array  $conditions,
        public readonly string $event
    )
    {
    }
}
