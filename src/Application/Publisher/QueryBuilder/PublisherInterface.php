<?php

namespace App\Application\Publisher\QueryBuilder;

use App\Application\Event\QueryBuilder\EventInterface;
use App\Application\EventSubscriber\QueryBuilder\EventSubscriberInterface;

interface PublisherInterface
{
    public function subscribe(EventSubscriberInterface $subscriber): void;

    public function unsubscribe(EventSubscriberInterface $subscriber): void;

    public function notify(EventInterface $event): void;
}
