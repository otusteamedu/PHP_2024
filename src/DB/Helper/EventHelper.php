<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Helper;

use AlexanderGladkov\DB\Event\QueryResultIsCreatedEvent;
use AlexanderGladkov\DB\Event\SqlIsExecutedEvent;
use AlexanderGladkov\DB\Publisher\Publisher;
use AlexanderGladkov\DB\QueryResult\QueryResultInterface;
use PDOStatement;

class EventHelper
{
    public function sendQueryResultIsCreatedEvent(?Publisher $publisher, QueryResultInterface $queryResult): void
    {
        if ($publisher === null) {
            return;
        }

        (new QueryResultIsCreatedEvent($queryResult))->send($publisher);
    }

    public function sendSqlIsExecutedEvent(?Publisher $publisher, PDOStatement $executedStatement): void
    {
        if ($publisher === null) {
            return;
        }

        $sql = (new StatementHelper())->getSentSqlFromExecutedStatement($executedStatement);
        if ($sql === null) {
            return;
        }

        (new SqlIsExecutedEvent($sql))->send($publisher);
    }
}
