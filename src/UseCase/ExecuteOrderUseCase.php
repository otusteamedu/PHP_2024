<?php

declare(strict_types=1);

namespace App\UseCase;

use App\ChainResponsibility\OrderHandler;
use App\Dto\Order;

class ExecuteOrderUseCase
{
    public function __construct(private OrderHandler $orderHandler)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Order $order): void
    {
        $this->orderHandler->handle($order);
    }
}
