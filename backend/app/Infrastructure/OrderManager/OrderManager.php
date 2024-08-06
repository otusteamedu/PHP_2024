<?php

namespace App\Infrastructure\OrderManager;

use App\Application\UseCase\CreateOrder;
use App\Domain\Entity\OrderEntity;
use App\Domain\ValueObject\AccountValueObject;
use App\Domain\ValueObject\AmountValueObject;
use App\Domain\ValueObject\CurrencyValueObject;
use App\Domain\ValueObject\EmailValueObject;
use App\Infrastructure\Repository\DbWorkflow;
use Illuminate\Http\Request;

class OrderManager
{
    public function createOrder(Request $request)
    {
        $orderEntity = new OrderEntity(
            new CurrencyValueObject($request->input('curFrom')),
            new CurrencyValueObject($request->input('curTo')),
            new AmountValueObject($request->input('amountFrom')),
            new AmountValueObject($request->input('amountTo')),
            new AmountValueObject($request->input('rateFrom')),
            new AmountValueObject($request->input('rateTo')),
            new EmailValueObject($request->input('email')),
            new AccountValueObject($request->input('account'))
        );

        $createOrderUseCase = new CreateOrder(
            $orderEntity,
            new DbWorkflow
        );

        return $createOrderUseCase();
    }

    public function PaidOrder($orderId, $newStatus)
    {
        // Implementation to update the order status
        // ...
    }

    public function CancelOrder($orderId)
    {
        // Implementation to cancel the order
        // ...
    }

    public function GetOrderDetails($orderId)
    {
        // Implementation to retrieve order details
        // ...
    }

    public function CompleteOrder($orderId)
    {
        // Implementation to retrieve order details
        // ...
    }

}
