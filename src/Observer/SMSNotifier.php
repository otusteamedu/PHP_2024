<?php

namespace App\Observer;

class SMSNotifier implements OrderObserverInterface
{
    public function update(string $status, int $orderId): void
    {
        echo "SMS NOTIFICATION: Order #{$orderId} - {$status}\n";
    }
}
