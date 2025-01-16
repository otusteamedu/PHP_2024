<?php

declare(strict_types=1);

namespace App\Banking\Notification;

/**
 * @template-implements NotificationTransportInterface<EmailNotification>
 */
final readonly class EmailNotificationTransport implements NotificationTransportInterface
{
    public function send(NotificationInterface $notification): void
    {
        // TODO: implement email sending
    }
}
