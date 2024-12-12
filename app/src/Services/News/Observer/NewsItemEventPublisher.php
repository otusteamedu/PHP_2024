<?php

declare(strict_types=1);

namespace App\Services\News\Observer;

class NewsItemEventPublisher
{
    private array $subscribers = [];

    public function subscribe(NewsItemSubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function notify(NewsItemCreateEvent $event)
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->notify($event);
        }
    }
}
