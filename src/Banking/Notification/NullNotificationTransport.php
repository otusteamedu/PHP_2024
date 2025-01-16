<?php

declare(strict_types=1);

namespace App\Banking\Notification;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class NullNotificationTransport implements NotificationTransportInterface
{
    public function send(NotificationInterface $notification): void
    {
        $stream = __DIR__ . '/../../../var/log/notifications.log';

        (new Logger('name'))
            ->pushHandler(new StreamHandler($stream))
            ->info('The notification was sent', $notification->toArray())
        ;
    }
}
