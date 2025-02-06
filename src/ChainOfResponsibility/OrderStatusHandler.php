<?php

namespace VladimirGrinko\Patterns\ChainOfResponsibility;

class OrderStatusHandler
{
    protected ?OrderStatusHandler $nextHandler = null;

    public function setNext(OrderStatusHandler $handler): OrderStatusHandler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(string $status): void
    {
        if ($this->nextHandler) {
            $this->nextHandler->handle($status);
        }
    }
}
