<?php

use App\Domain\Entities\Order;

class OrderHandler extends AbstractHandler
{
    public function handle(Order $order): void
    {
        // todo: проверить оплату, сохранить заказ.

        parent::handle($order);
    }
}