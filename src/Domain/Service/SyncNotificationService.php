<?php

namespace App\Domain\Service;

use App\Domain\NotificationBusInterface\NotificationSenderInterface;
use Telegram\Bot\Objects\Update;

class SyncNotificationService
{
    public function __construct(
        private readonly NotificationSenderInterface $notificationSender,
    ) {
    }

    public function sendUpdateNotificationToSyncBus(Update $update): void
    {
        $this->notificationSender->sendUpdateNotification($update);
    }

}
