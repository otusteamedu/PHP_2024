<?php

declare(strict_types=1);

namespace Infrastructure\Notification;

use Domain\Notification\Services\NotificationServiceInterface;
use Domain\Trading\Entities\Trade;
use Domain\User\Entities\User;

class TradeNotificationService
{
    private NotificationServiceInterface $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendNotification(User $user, Trade $trade): void
    {
        $message = $this->generateMessage($trade);
        $this->notificationService->send($user, $message);
    }

    private function generateMessage(Trade $trade): string
    {
        $tradeType = $trade->getType()->getName();
        $asset = $trade->getAsset()->getName();
        $quantity = $trade->getQuantity();
        $price = $trade->getPrice();

        return "Trade Notification: $tradeType $quantity $asset at $price";
    }
}
