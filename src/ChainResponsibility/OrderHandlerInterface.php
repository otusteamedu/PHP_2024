<?php

declare(strict_types=1);

namespace App\ChainResponsibility;

use App\Dto\Order;

interface OrderHandlerInterface
{
    public function handle(Order $order): void;
    public function setNextHandler(OrderHandlerInterface $nextHandler): void;
}
