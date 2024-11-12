<?php

declare(strict_types=1);

namespace Domain\Trading\Entities;

use Domain\Notification\Services\NotificationServiceInterface;
use Domain\User\Entities\User;

class TradeService
{
    private NotificationServiceInterface $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function notifyUserAboutTrade(User $user, Trade $trade): void
    {
        // Создание объекта TradeNotification
        $tradeNotification = new TradeNotification($user, $trade, $this->notificationService);

        // Отправка уведомления
        $tradeNotification->sendNotification();
    }
}
