<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\SelectQuery;

use AlexanderGladkov\DB\Helper\EventHelper;
use AlexanderGladkov\DB\QueryResult\QueryResult;
use AlexanderGladkov\DB\QueryResult\QueryResultInterface;
use PDO;

class SelectQuery extends AbstractSelectQuery
{
    public function execute(): QueryResultInterface
    {
        $eventHelper = new EventHelper();
        $statement = $this->createStatement();
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);
        $eventHelper->sendSqlIsExecutedEvent($this->publisher, $statement);

        $queryResult = new QueryResult($rows);
        $eventHelper->sendQueryResultIsCreatedEvent($this->publisher, $queryResult);
        return $queryResult;
    }
}
