<?php

declare(strict_types=1);

namespace App\Services\News\Observer;

interface NewsItemSubscriberInterface
{
    public function update(NewsItemCreateEvent $event): void;
}
