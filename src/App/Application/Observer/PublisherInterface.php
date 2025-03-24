<?php

namespace App\Application\Observer;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber);
    public function unsubscribe(SubscriberInterface $subscriber);
    public function notify(Event $event);
}