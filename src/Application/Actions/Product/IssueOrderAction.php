<?php

declare(strict_types=1);

namespace App\Application\Actions\Product;

use App\Domain\Enum\OrderStatuses;
use App\Domain\Order\Order;

class IssueOrderAction
{
    public function execute(Order $order): void
    {
        # some logic
        $order->setStatus(OrderStatuses::ForPickup);
    }
}
