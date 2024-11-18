<?php

namespace App\Application\QueryBuilder\EventSubscriber;

use App\Application\QueryBuilder\Event\EventInterface;

interface EventSubscriberInterface
{
    public function update(EventInterface $event): void;
}
