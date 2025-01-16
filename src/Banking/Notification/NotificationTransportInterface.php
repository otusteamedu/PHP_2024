<?php

declare(strict_types=1);

namespace App\Banking\Notification;

/**
 * @template T of NotificationInterface
 */
interface NotificationTransportInterface
{
    /**
     * @param T $notification
     */
    public function send(NotificationInterface $notification): void;
}
