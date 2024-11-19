<?php

namespace App\Application\EventSubscriber\QueryBuilder;

use App\Application\Event\QueryBuilder\AbstractQueryBuilderEvent;
use App\Application\Event\QueryBuilder\EventInterface;

class QueryBuilderSubscriber implements EventSubscriberInterface
{
    public function update(EventInterface $event): void
    {
//        echo  PHP_EOL;
//        /** @var  AbstractQueryBuilderEvent $event*/
//        echo 'событие: ' . $event->databaseQueryResultClassName . PHP_EOL;
//        echo 'DBQR-объект: ' . $event->eventClassName . PHP_EOL;
//        echo 'SQL-запрос: ' . ($event->query ?? 'null') . PHP_EOL;
//        echo 'результат запроса: ' . json_encode($event->result, JSON_UNESCAPED_UNICODE) . PHP_EOL;
//        echo  PHP_EOL;
    }
}
