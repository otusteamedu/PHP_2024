<?php

namespace App\Observer;

class EmailNotifier implements OrderObserverInterface
{
    public function update(string $status, int $orderId): void
    {
        echo "EMAIL NOTIFICATION: Order #{$orderId} - {$status}\n";
    }
}
