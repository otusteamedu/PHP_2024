<?php

namespace App\Infrastructure\Observer;

use App\Application\Observer\Event;
use App\Application\Observer\PublisherInterface;
use App\Application\Observer\SubscriberInterface;

abstract class Publisher implements PublisherInterface
{
    /** @var SubscriberInterface[] array  */
    protected array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber)
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber)
    {
        foreach ($this->subscribers as $key => $s) {
            if ($subscriber === $s) {
                unset($this->subscribers[$key]);
            }
        }
    }

    abstract public function notify(Event $event);
}