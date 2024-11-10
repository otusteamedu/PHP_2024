<?php

namespace App\Application\Actions\Orders;

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;

class CreateOrder
{
    public function __invoke(OrderRepositoryInterface $orderRepository): Order
    {
        //todo: можно использовать опять же фабрику какую-нибудь.
        $order = new Order();

        return $orderRepository->save($order);
    }
}
