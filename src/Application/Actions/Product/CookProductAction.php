<?php

declare(strict_types=1);

namespace App\Application\Actions\Product;

use App\Domain\Enum\OrderStatuses;
use App\Domain\Order\Order;
use App\Domain\Product\HasCompositionInterface;

class CookProductAction
{
    public function execute(HasCompositionInterface $product, Order $order): void
    {
        # some logic
        $order->setStatus(OrderStatuses::Cooking);
    }
}
