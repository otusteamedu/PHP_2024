<?php

declare(strict_types=1);

namespace Viking311\Queue\Application\Notification;

use Viking311\Queue\Domain\Entity\Event;

interface NotificationInterface
{
    public function send(Event $event);
}
