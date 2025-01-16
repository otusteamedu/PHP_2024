<?php

declare(strict_types=1);

namespace App\Banking\Notification;

interface NotificationInterface
{
    public function toArray(): array;
}
