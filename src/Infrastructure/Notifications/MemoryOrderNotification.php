<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Infrastructure\Notifications;

use RailMukhametshin\Hw\Domain\Entity\Order;
use RailMukhametshin\Hw\Domain\Notifications\OrderNotificationInterface;

class MemoryOrderNotification implements OrderNotificationInterface
{
    private array $notifications = [];

    public function notifyAboutSetRating(Order $order): void
    {
        $text = sprintf('Order: %s \r\n Rating: %s', $order->getId(), $order->getRating()->getValue());
        $this->notifications[] = $text;
    }
}