<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Event;

use AlexanderGladkov\DB\Publisher\Publisher;

class SqlIsExecutedEvent extends AbstractEvent
{
    public function __construct(private string $sql)
    {
    }

    public function send(Publisher $publisher): void
    {
        $publisher->publishSqlIsExecutedEvent($this);
    }

    public function getSql(): string
    {
        return $this->sql;
    }
}
