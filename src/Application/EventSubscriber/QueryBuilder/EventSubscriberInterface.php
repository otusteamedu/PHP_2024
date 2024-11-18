<?php

namespace App\Application\EventSubscriber\QueryBuilder;

use App\Application\Event\QueryBuilder\EventInterface;

interface EventSubscriberInterface
{
    public function update(EventInterface $event): void;
}
