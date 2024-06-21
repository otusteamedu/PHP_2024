<?php

declare(strict_types=1);

namespace AlexanderGladkov\Demo;

use AlexanderGladkov\DB\Event\QueryResultIsCreatedEvent;
use AlexanderGladkov\DB\Event\SqlIsExecutedEvent;
use AlexanderGladkov\DB\Subscriber\QueryResultIsCreatedSubscriberInterface;
use AlexanderGladkov\DB\Subscriber\SqlIsExecutedSubscriberInterface;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Psr\Log\LoggerInterface;

class LogService implements QueryResultIsCreatedSubscriberInterface, SqlIsExecutedSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(string $logPatch)
    {
        $this->logger = new Logger('app');
        $this->logger->pushHandler(new StreamHandler($logPatch, Level::Debug));
        $this->logger->pushHandler(new FirePHPHandler());
    }

    public function processQueryResultIsCreatedEvent(QueryResultIsCreatedEvent $event): void
    {
        $this->logger->info('QueryResult is created');
    }

    public function processSqlIsExecutedEvent(SqlIsExecutedEvent $event): void
    {
        $this->logger->info('SQL is executed: ' . $event->getSql());
    }
}
