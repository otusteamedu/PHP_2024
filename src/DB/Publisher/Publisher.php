<?php

declare(strict_types=1);

namespace AlexanderGladkov\DB\Publisher;

use AlexanderGladkov\DB\Event\QueryResultIsCreatedEvent;
use AlexanderGladkov\DB\Subscriber\QueryResultIsCreatedSubscriberInterface;
use AlexanderGladkov\DB\Event\SqlIsExecutedEvent;
use AlexanderGladkov\DB\Subscriber\SqlIsExecutedSubscriberInterface;
use AlexanderGladkov\DB\Subscriber\SubscriberInterface;

class Publisher
{
    private array $subscribers = [];

    public function subscribeQueryResultsIsCreatedEvent(QueryResultIsCreatedSubscriberInterface $subscriber): void
    {
        $this->subscribe(QueryResultIsCreatedEvent::class, $subscriber);
    }

    public function subscribeSqlIsExecutedEvent(SqlIsExecutedSubscriberInterface $subscriber): void
    {
        $this->subscribe(SqlIsExecutedEvent::class, $subscriber);
    }

    public function publishQueryIsCreatedEvent(QueryResultIsCreatedEvent $event): void
    {
        /**
         * @var QueryResultIsCreatedSubscriberInterface[] $subscribers
         */
        $subscribers = $this->getSubscribersByEventName($event::class);
        foreach ($subscribers as $subscriber) {
            $subscriber->processQueryResultIsCreatedEvent($event);
        }
    }

    public function publishSqlIsExecutedEvent(SqlIsExecutedEvent $event): void
    {
        /**
         * @var SqlIsExecutedSubscriberInterface[] $subscribers
         */
        $subscribers = $this->getSubscribersByEventName($event::class);
        foreach ($subscribers as $subscriber) {
            $subscriber->processSqlIsExecutedEvent($event);
        }
    }

    private function subscribe(string $eventName, SubscriberInterface $subscriber): void
    {
        if (!isset($this->subscribers[$eventName])) {
            $this->subscribers[$eventName] = [];
        }

        $this->subscribers[$eventName][] = $subscriber;
    }

    private function getSubscribersByEventName(string $eventName): array
    {
        return $this->subscribers[$eventName] ?? [];
    }
}
