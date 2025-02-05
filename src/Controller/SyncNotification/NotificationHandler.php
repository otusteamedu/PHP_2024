<?php

namespace App\Controller\SyncNotification;

use App\Domain\DTO\Notification\UpdateNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotificationHandler
{
    public function __invoke(UpdateNotification $message)
    {
        # todo наполнить функцию для отладки
    }
}
