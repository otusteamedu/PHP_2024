<?php

namespace App\Application\Publisher\QueryBuilder;

use App\Application\Event\QueryBuilder\EventInterface;
use App\Application\EventSubscriber\QueryBuilder\EventSubscriberInterface;

class QueryBuilderPublisher implements PublisherInterface
{
    /** @var PublisherInterface */
    private array $subscribers = [];

    public function subscribe(EventSubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(EventSubscriberInterface $subscriber): void
    {
        // todo механизм удаления подписки
    }

    public function notify(EventInterface $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($event);
        }
    }
}
