<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Subscriber;

use AlexanderGladkov\DB\Event\QueryResultIsCreatedEvent;

interface QueryResultIsCreatedSubscriberInterface extends SubscriberInterface
{
    public function processQueryResultIsCreatedEvent(QueryResultIsCreatedEvent $event): void;
}
