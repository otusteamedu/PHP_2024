<?php

declare(strict_types=1);

namespace Domain\Trading\Entities;

use Domain\Notification\Services\NotificationServiceInterface;
use Domain\User\Entities\User;

class TradeNotification
{
    private User $user;
    private Trade $trade;
    private NotificationServiceInterface $notificationService;

    public function __construct(User $user, Trade $trade, NotificationServiceInterface $notificationService)
    {
        $this->user = $user;
        $this->trade = $trade;
        $this->notificationService = $notificationService;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTrade(): Trade
    {
        return $this->trade;
    }

    public function sendNotification(): void
    {
        $message = $this->generateMessage();
        $this->notificationService->send($this->user, $message);
    }

    private function generateMessage(): string
    {
        $tradeType = $this->trade->getType()->getName();
        $asset = $this->trade->getAsset()->getName();
        $quantity = $this->trade->getQuantity();
        $price = $this->trade->getPrice();

        return "Trade Notification: $tradeType $quantity $asset at $price";
    }
}
