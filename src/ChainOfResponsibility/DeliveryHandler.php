<?php

namespace VladimirGrinko\Patterns\ChainOfResponsibility;

class DeliveryHandler extends OrderStatusHandler
{
    public function handle(string $status): void
    {
        if ($status === 'delivery') {
            $this->notify("Заказ передан курьеру.");
        }
        parent::handle($status);
    }

    private function notify(string $message): void
    {
        echo $message . PHP_EOL;
    }
}