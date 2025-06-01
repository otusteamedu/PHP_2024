<?php

namespace App\Observer;

class AppNotifier implements OrderObserverInterface
{
    public function update(string $status, int $orderId): void
    {
        echo "APP NOTIFICATION: Order #{$orderId} - {$status}\n";
    }
}
