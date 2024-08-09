<?php

namespace App\Infrastructure\OrderManager;

use App\Application\Interface\Repository;
use App\Application\UseCase\CreateOrderUseCase;
use App\Domain\Entity\OrderEntity;
use App\Domain\ValueObject\AccountValueObject;
use App\Domain\ValueObject\AmountValueObject;
use App\Domain\ValueObject\CurrencyValueObject;
use App\Domain\ValueObject\EmailValueObject;
use App\Infrastructure\PaymentManager\PaymentManager;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderManager
{

    const STATUS_CANCEL = 0;
    const STATUS_WAITING = 1;

    private int $orderLifetime;
    private PaymentManager $paymentManager;
    public function __construct(
        public Repository $repository
    ){
        // Initialize payment manager
        $this->paymentManager = new PaymentManager($this->repository);

        $this->orderLifetime = config('app.ORDER_EXPIRE_TIME');;
    }
    public function createOrder(Request $request): int
    {
        $curFrom = new CurrencyValueObject($request->input('curFrom'));

        $incomingAsset = $this->paymentManager->getIncomingAsset($curFrom->currencyCode);

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
            $this->repository
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
        $this->repository->updateOrderStatus($orderId,self::STATUS_CANCEL);
        return self::STATUS_CANCEL;
    }

    public function getOrderById(int $orderId)
    {
        return $this->repository->getRowById($orderId);
    }

    public function completeOrder($orderId)
    {
        // Implementation to retrieve order details
        // ...
    }

    public function checkAwaitOrders()
    {
    }

    private function getAwaitCryptoOrders(): array
    {
        # TODO: Создать перекрестную выборку таблиц ордерс и курренси на наличие типа Crypto

        $orders = [];
        $ordersAll = $this->repository->getRowsWhere('status', self::STATUS_WAITING);

        foreach ($ordersAll as $order) {
            $dt = Carbon::parse($order->created_at);
            if (Carbon::parse(now()) > $dt->addSeconds($this->orderLifetime)) continue;
            $orders[] = $order;
        }

        return $orders;
    }

    public function test()
    {
        // For testing purposes

    }

    public function checkOrderCryptoDeposit()
    {
        $awaitOrders = $this->getAwaitCryptoOrders();
        foreach ($awaitOrders as $order) {

            # Проверить,
        }
    }

}
