<?php

namespace App\Observer;

interface OrderObserverInterface
{
    public function update(string $status, int $orderId): void;
}
