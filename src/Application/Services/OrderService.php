<?php

use App\Domain\Entities\Order;

class OrderService
{
    public function process(Order $order): void
    {
        $orderHandler = new OrderHandler();
        $kitchenHandler = new KitchenHandler();
        $deliveryHandler = new FloorHandler();

        $orderHandler
            ->setNext($kitchenHandler)
            ->setNext($deliveryHandler);

        $orderHandler->handle($order);
    }
}
