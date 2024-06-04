<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Publisher;

use Kagirova\Hw21\Application\Service\NotificationService;
use Kagirova\Hw21\Domain\Event\NewsIsCreatedEvent;
use Kagirova\Hw21\Domain\Exception\DuplicatedSubscriptionError;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;
use Kagirova\Hw21\Domain\Subscriber\SubscriberInterface;

class Publisher implements PublisherInterface
{
    private static array $subscribers;
    private static StorageInterface $storage;

    public static function init(StorageInterface $storage)
    {
        Publisher::$storage = $storage;
        if (!isset(Publisher::$subscribers)) {
            Publisher::$subscribers = [];
            $subscriptions = $storage->getAllSubscription();
            foreach ($subscriptions as $subscription) {
                Publisher::$subscribers[] = array($subscription, new NotificationService());
            }
        }
    }

    public static function subscribe(SubscriberInterface $subscriber, int $categoryId): void
    {
        if (in_array(Publisher::$subscribers, array($categoryId, $subscriber))) {
            throw new DuplicatedSubscriptionError();
        }
        Publisher::$subscribers[] = array($categoryId, $subscriber);
        array_push(Publisher::$subscribers, array($categoryId, $subscriber));
    }

    public static function notify(NewsIsCreatedEvent $event): void
    {
        foreach (Publisher::$subscribers as $subscriber) {
            if ($event->getCategoryId() == $subscriber[0]) {
                $subscriber[1]->update($event);
            }
        }
    }
}
