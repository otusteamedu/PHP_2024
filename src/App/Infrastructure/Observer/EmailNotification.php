<?php

namespace App\Infrastructure\Observer;

use App\Application\Observer\Event;
use App\Application\Observer\SubscriberInterface;

class EmailNotification implements SubscriberInterface
{
    public function update(StatusEvent|Event $event)
    {
        echo 'Статус изменился ' . $event->status;
    }
}