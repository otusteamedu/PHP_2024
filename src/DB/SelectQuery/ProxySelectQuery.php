<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\SelectQuery;

use AlexanderGladkov\DB\Helper\EventHelper;
use AlexanderGladkov\DB\QueryResult\QueryResultInterface;
use AlexanderGladkov\DB\QueryResult\ProxyQueryResult;
use PDO;

class ProxySelectQuery extends AbstractSelectQuery
{
    public function execute(): QueryResultInterface
    {
        $eventHelper = new EventHelper();

        $queryResult = new ProxyQueryResult(function () use ($eventHelper) {
            $statement = $this->createStatement();
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            $eventHelper->sendSqlIsExecutedEvent($this->publisher, $statement);
            return $result;
        });

        $eventHelper->sendQueryResultIsCreatedEvent($this->publisher, $queryResult);
        return $queryResult;
    }
}
