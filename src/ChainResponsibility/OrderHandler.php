<?php

declare(strict_types=1);

namespace App\ChainResponsibility;

use App\Dto\Order;

class OrderHandler implements OrderHandlerInterface
{
    protected ?OrderHandlerInterface $nextHandler = null;
    public function handle(Order $order): void
    {
        $this->nextHandler?->handle($order);
    }

    public function setNextHandler(OrderHandlerInterface $nextHandler): void
    {
        $this->nextHandler = $nextHandler;
    }
}
