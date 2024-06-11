<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Subscriber;

use Kagirova\Hw21\Domain\Event\NewsIsCreatedEvent;

interface SubscriberInterface
{
    public function update(NewsIsCreatedEvent $event): void;
}
