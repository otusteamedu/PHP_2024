<?php

declare(strict_types=1);

namespace App\Layer\Infrastructure\Http\Response;

use App\Layer\Application\UseCase\CreateOrderResponseInterface;
use App\Layer\Domain\Entity\Order\Order;

class CreateOrderResponse implements CreateOrderResponseInterface
{
    public function getResponse(Order $order): string
    {
        $products = [];

        foreach ($order->compositeItems as $compositeItem) {
            $products[] = [
                'status' => $compositeItem->getStatusProduct()->name,
                'price' => $compositeItem->price,
                'name' => $compositeItem->getName(),
                'message' => $compositeItem->message ?? null
            ];
        }

        $order_response = [
            "order" => [
                "product" => $products,
                "total price" => $order->price,
            ]
        ];

        return json_encode($order_response);
    }
}
