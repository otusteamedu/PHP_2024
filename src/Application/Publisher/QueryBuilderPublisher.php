<?php

namespace App\Application\QueryBuilder\Publisher;

use App\Application\QueryBuilder\Event\EventInterface;
use App\Application\QueryBuilder\EventSubscriber\EventSubscriberInterface;

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
