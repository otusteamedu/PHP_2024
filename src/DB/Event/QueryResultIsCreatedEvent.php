<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Event;

use AlexanderGladkov\DB\Publisher\Publisher;
use AlexanderGladkov\DB\QueryResult\QueryResultInterface;

class QueryResultIsCreatedEvent extends AbstractEvent
{
    public function __construct(private QueryResultInterface $queryResult)
    {
    }

    public function send(Publisher $publisher): void
    {
        $publisher->publishQueryIsCreatedEvent($this);
    }

    public function getQueryResult(): QueryResultInterface
    {
        return $this->queryResult;
    }
}
