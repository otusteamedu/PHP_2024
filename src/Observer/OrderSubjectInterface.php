<?php

namespace App\Observer;

interface OrderSubjectInterface
{
    public function attach(OrderObserverInterface $observer): void;
    public function detach(OrderObserverInterface $observer): void;
    public function notify(string $status, int $orderId): void;
}
