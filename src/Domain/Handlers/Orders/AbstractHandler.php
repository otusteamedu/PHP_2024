<?php

use App\Domain\Entities\Order;

abstract class AbstractHandler
{
    protected ?AbstractHandler $nextHandler = null;

    public function setNext(AbstractHandler $handler): AbstractHandler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(Order $order): void
    {
        if ($this->nextHandler !== null) {
            $this->nextHandler->handle($order);
        }
    }
}
