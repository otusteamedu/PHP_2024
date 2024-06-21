<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Event;

use AlexanderGladkov\DB\Publisher\Publisher;

abstract class AbstractEvent
{
    abstract public function send(Publisher $publisher): void;
}
