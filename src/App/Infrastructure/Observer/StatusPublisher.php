<?php

namespace App\Infrastructure\Observer;

use App\Application\Observer\Event;

class StatusPublisher extends Publisher
{
    public function notify(StatusEvent|Event $event)
    {
        foreach ($this->subscribers as $s) {
            $s->update($event);
        }
    }
}