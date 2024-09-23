<?php

use App\Domain\Entities\Order;

class KitchenHandler extends AbstractHandler
{
    public function handle(Order $order): void
    {
        // todo: проверить продукты, начать готовку

        parent::handle($order);
    }
}