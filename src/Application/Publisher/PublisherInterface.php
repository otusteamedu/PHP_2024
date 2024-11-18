<?php

namespace App\Application\QueryBuilder\Publisher;

use App\Application\QueryBuilder\Event\EventInterface;
use App\Application\QueryBuilder\EventSubscriber\EventSubscriberInterface;

interface PublisherInterface
{
    public function subscribe(EventSubscriberInterface $subscriber): void;

    public function unsubscribe(EventSubscriberInterface $subscriber): void;

    public function notify(EventInterface $event): void;
}
