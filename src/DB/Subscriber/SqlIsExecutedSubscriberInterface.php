<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Subscriber;

use AlexanderGladkov\DB\Event\SqlIsExecutedEvent;

interface SqlIsExecutedSubscriberInterface extends SubscriberInterface
{
    public function processSqlIsExecutedEvent(SqlIsExecutedEvent $event): void;
}
