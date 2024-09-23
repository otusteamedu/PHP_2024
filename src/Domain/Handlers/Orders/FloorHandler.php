<?php

use App\Application\Actions\Products\CreateBurger;
use App\Application\Enums\Recipes\BurgerType;
use App\Application\Factories\Products\BurgerFactory;
use App\Domain\Entities\Order;

class FloorHandler extends AbstractHandler
{
    public function handle(Order $order): void
    {
        // todo: отдать заказ клиенту

        parent::handle($order);
    }
}