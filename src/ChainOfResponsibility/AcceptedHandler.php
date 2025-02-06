<?php

namespace VladimirGrinko\Patterns\ChainOfResponsibility;

class AcceptedHandler extends OrderStatusHandler
{
    public function handle(string $status): void
    {
        if ($status === 'accepted') {
            $this->notify("Заказ принят в обработку.");
        }
        parent::handle($status);
    }

    private function notify(string $message): void
    {
        echo $message . PHP_EOL;
    }
}