<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Domain\Notifications;

use RailMukhametshin\Hw\Domain\Entity\Order;

interface OrderNotificationInterface
{
    public function notifyAboutSetRating(Order $order): void;
}