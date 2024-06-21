<?php

declare(strict_types=1);

namespace AlexanderGladkov\Demo;

use AlexanderGladkov\DB\Publisher\Publisher;
use AlexanderGladkov\DB\QueryResult\QueryResultInterface;
use AlexanderGladkov\DB\SelectQuery\SelectQueryInterface;
use AlexanderGladkov\DB\SelectQuery\ProxySelectQuery;
use PDO;

class Application
{
    public function run(): void
    {
        $config = new Config();
        $pdo = $this->createPDO($config);
        $publisher = $this->createPublisher($config);
        $selectQuery = new ProxySelectQuery($pdo, $publisher);
        $this->testSelectQuery($selectQuery);
    }

    private function testSelectQuery(SelectQueryInterface $selectQuery): void
    {
        $queryResult = $selectQuery
            ->from('movies')
            ->where('duration', 110)
            ->orderBy('release_date', 'DESC')
            ->execute();

        $this->outputQueryResult($queryResult);
    }

    private function outputQueryResult(QueryResultInterface $queryResult)
    {
        echo '<pre>';
        foreach ($queryResult as $row) {
            print_r($row);
            echo '<br>';
        }
        echo '</pre>';
    }

    private function createPDO(Config $config): PDO
    {
        return (new PDOFactory())->create(
            $config->getDbHost(),
            $config->getDbPort(),
            $config->getDbName(),
            $config->getDbUser(),
            $config->getDbPassword()
        );
    }

    private function createPublisher(Config $config): Publisher
    {
        $publisher = new Publisher();
        $logService = new LogService($config->getLogPath());
        $publisher->subscribeQueryResultsIsCreatedEvent($logService);
        $publisher->subscribeSqlIsExecutedEvent($logService);
        return $publisher;
    }
}
