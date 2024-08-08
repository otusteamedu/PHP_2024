<?php

namespace App\Infrastructure\OrderManager;

use App\Application\UseCase\CreateOrderUseCase;
use App\Domain\Entity\OrderEntity;
use App\Domain\ValueObject\AccountValueObject;
use App\Domain\ValueObject\AmountValueObject;
use App\Domain\ValueObject\CurrencyValueObject;
use App\Domain\ValueObject\EmailValueObject;
use App\Infrastructure\PaymentManager\CryptoManager\CryptoApi;
use App\Infrastructure\PaymentManager\CryptoManager\CryptoManager;
use App\Infrastructure\Repository\DbWorkflow;
use Illuminate\Http\Request;

class OrderManager
{

    const STATUS_CANCEL = 0;

    public function createOrder(Request $request): int
    {
        $curFrom = new CurrencyValueObject($request->input('curFrom'));

        $incomingAsset = $this->getIncomingAsset($curFrom->currencyCode);

        $orderEntity = new OrderEntity(
            $curFrom,
            new CurrencyValueObject($request->input('curTo')),
            new AmountValueObject($request->input('amountFrom')),
            new AmountValueObject($request->input('amountTo')),
            new AmountValueObject($request->input('rateFrom')),
            new AmountValueObject($request->input('rateTo')),
            new EmailValueObject($request->input('email')),
            new AccountValueObject($request->input('account')),
            new AccountValueObject($incomingAsset)
        );

        $createOrderUseCase = new CreateOrderUseCase(
            $orderEntity,
            new DbWorkflow
        );

        return $createOrderUseCase();
    }

    public function paidOrder($orderId, $newStatus)
    {
        // Implementation to update the order status
        // ...
    }

    /**
     * @throws \Exception
     */
    public function cancelOrderById($orderId): int
    {
        (new DbWorkflow)->updateOrderStatus($orderId,self::STATUS_CANCEL);
        return self::STATUS_CANCEL;
    }

    public function getOrderById(int $orderId)
    {
        return (new DbWorkflow)->getRowById($orderId);
    }

    public function completeOrder($orderId)
    {
        // Implementation to retrieve order details
        // ...
    }


    public function getIncomingAsset(string $cur): string
    {
        $curType = (new DbWorkflow)->getCurType($cur);
        $incomingAsset = 'Ничего не найдено';
        if ($curType === 'crypto') {
            $cryptoManager = new CryptoManager(new CryptoApi);
            $incomingAsset = $cryptoManager->getIncomingAsset($cur);
        }
        return $incomingAsset;
    }

}
