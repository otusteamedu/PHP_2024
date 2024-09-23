<?php

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function save(Order $order): Order
    {
        //todo: store to database

        return $order;
    }
}
