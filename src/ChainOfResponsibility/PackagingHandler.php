<?php

namespace VladimirGrinko\Patterns\ChainOfResponsibility;

class PackagingHandler extends OrderStatusHandler
{
    public function handle(string $status): void
    {
        if ($status === 'packaging') {
            $this->notify("Упаковка заказа.");
        }
        parent::handle($status);
    }

    private function notify(string $message): void
    {
        echo $message . PHP_EOL;
    }
}