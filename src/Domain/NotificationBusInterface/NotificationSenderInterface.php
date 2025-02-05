<?php

namespace App\Domain\NotificationBusInterface;

use Telegram\Bot\Objects\Update;

interface NotificationSenderInterface
{
    public function sendUpdateNotification(Update $update): void;
}
