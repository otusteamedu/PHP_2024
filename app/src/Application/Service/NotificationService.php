<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Service;

use Kagirova\Hw21\Domain\Event\NewsIsCreatedEvent;
use Kagirova\Hw21\Domain\Subscriber\SubscriberInterface;

class NotificationService implements SubscriberInterface
{
    public function update(NewsIsCreatedEvent $event): void
    {
        echo "Новая новость в категории: https://test.ru/news/{$event->getNewsId()}";
        echo PHP_EOL;
    }
}
