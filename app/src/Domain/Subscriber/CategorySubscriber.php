<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Subscriber;

use Kagirova\Hw21\Domain\Event\NewsIsCreatedEvent;

class CategorySubscriber implements SubscriberInterface
{
    public function update(NewsIsCreatedEvent $event): void
    {
        echo "Создана новая новость категории " . $event->getCategoryName() . "\n https://news/" . $event->getNewsId();
    }
}
