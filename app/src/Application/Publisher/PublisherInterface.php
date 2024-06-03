<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Publisher;

use Kagirova\Hw21\Domain\Event\NewsIsCreatedEvent;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;
use Kagirova\Hw21\Domain\Subscriber\SubscriberInterface;

interface PublisherInterface
{
    public static function init(StorageInterface $postgresStorage);

    public static function subscribe(SubscriberInterface $subscriber, int $categoryId): void;

    public static function unsubscribe(SubscriberInterface $subscriber, int $categoryId): void;

    public static function notify(NewsIsCreatedEvent $event): void;
}
