<?php

namespace App\Infrastructure\NotificationBus;

use App\Domain\DTO\Notification\UpdateNotification;
use App\Domain\NotificationBusInterface\NotificationSenderInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Telegram\Bot\Objects\Update;

class NotificationSender implements NotificationSenderInterface
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    ) {
    }

    public function sendUpdateNotification(Update $update): void
    {
        $this->bus->dispatch(new UpdateNotification($update));
    }
}
