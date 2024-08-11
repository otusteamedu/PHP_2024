<?php

declare(strict_types=1);

namespace App\Application\Bus\OrderStep;

use App\Application\DTO\OrderDto;
use App\Domain\Enum\OrderStatuses;

class FromKitchenToCachier extends AbstractStep
{
    public function handle(OrderDto $orderData): void
    {
        if (!$orderData->id) {
            parent::handle($orderData);
            return;
        }

        $order = $this->getOrder($orderData->id);

        if ($order->getStatus() !== OrderStatuses::Cooked) {
            parent::handle($orderData);
            return;
        }
    }

    private function getOrder(int $id): Order
    {
        # get order via repository
    }
}
