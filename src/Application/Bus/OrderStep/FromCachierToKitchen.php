<?php

declare(strict_types=1);

namespace App\Application\Bus\OrderStep;

use App\Application\Actions\Product\{BuildProductAction, CookProductAction};
use App\Application\DTO\OrderDto;
use App\Domain\Enum\OrderStatuses;
use App\Domain\Order\Order;

use function DI\get;

class FromCachierToKitchen extends AbstractStep
{
    public function handle(OrderDto $orderData): void
    {
        if ($orderData->id) {
            parent::handle($orderData);
            return;
        }

        $order = $this->createNewOrder();
        $product = (get(BuildProductAction::class))->execute(
            get($orderData->cook),
            get($orderData->cookingProcess),
            ...$orderData->productCustomizers
        );

        get(CookProductAction::class)->execute($product, $order);
    }

    private function createNewOrder(): Order
    {
        // create new order via repository
        $order = new Order();
        $order->setStatus(OrderStatuses::New);

        return $order;
    }
}
