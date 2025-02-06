<?php

namespace VladimirGrinko\Patterns\ChainOfResponsibility;

class CookingHandler extends OrderStatusHandler
{
    public function handle(string $status): void
    {
        if ($status === 'cooking') {
            $this->notify("Заказ готовится.");
        }
        parent::handle($status);
    }

    private function notify(string $message): void
    {
        echo $message . PHP_EOL;
    }
}