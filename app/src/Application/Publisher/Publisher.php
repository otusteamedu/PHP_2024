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
    private array $subscribers;
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        if (!isset($this->subscribers)) {
            $this->subscribers = [];
            $subscriptions = $storage->getAllSubscription();
            foreach ($subscriptions as $subscription) {
                $this->subscribers[] = array($subscription, new NotificationService());
            }
        }
    }

    public function subscribe(SubscriberInterface $subscriber, int $categoryId): void
    {
        if (in_array($this->subscribers, array($categoryId, $subscriber))) {
            throw new DuplicatedSubscriptionError();
        }
        $this->subscribers[] = array($categoryId, $subscriber);
        array_push($this->subscribers, array($categoryId, $subscriber));
    }

    public function notify(NewsIsCreatedEvent $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($event->getCategoryId() == $subscriber[0]) {
                $subscriber[1]->update($event);
            }
        }
    }
}
