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
use App\Models\CryptoDeposit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Builder\Class_;

class OrderManager
{


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
        $this->repository->updateOrderStatus($orderId,config('app.ORDER_STATUS_CANCEL'));
        return config('app.ORDER_STATUS_CANCEL');
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

    private function getAwaitCryptoOrders(): array|string
    {
        $orders = [];
        $ordersAll = $this->repository->getRowsOrderWhereCurfromIsCrypto('status', config('app.ORDER_STATUS_WAITING'));
        if (!count($ordersAll)) {
            throw new \InvalidArgumentException;
        }
        foreach ($ordersAll as $order) {
            $dt = Carbon::parse($order->created_at);
            if (Carbon::parse(now()) > $dt->addSeconds($this->orderLifetime)) continue;
            $orders[] = $order;
        }

        return $orders;
    }

    public function test()
    {
        //return $this->checkOrderCryptoDeposit();
        Log::debug("Checking orderCryptoDeposit");
    }

    public function checkOrderCryptoDeposit(): void
    {
        $awaitOrders = $this->getAwaitCryptoOrders();
        foreach ($awaitOrders as $order) {
            $currency = explode('_',$order->cur_from);
            $coin = $currency[0];
            $chain = $currency[1];
            $startTime = Carbon::parse($order->created_at)->timestamp - 3600 * 10;
            $endTime = ($startTime + $this->orderLifetime);
            $json = $this->paymentManager->checkCryptoDeposit(strtoupper($coin), $startTime, $endTime);

            $json = json_decode($json, true);

            // Validate and update order status if conditions are met
            foreach ($json['result']['rows'] as $row) {

                if (
                    $row['status'] === config('app.CRYPTO_DEPOSIT_ACCEPTED') &&
                    $row['chain'] === $this->paymentManager->cryptoManager->chains[$chain] &&
                    (float)$row['amount'] === (float)number_format($order->amount_from, 2) &&
                    !count($this->repository->getRowsWhere(CryptoDeposit::getTableName(),'txid', $row['txID']))
                ) {
                    Log::debug("Check deposit", [$row]);
                    // Update order status and save deposit
                    $depId = $this->repository->save(CryptoDeposit::getTableName(), [
                        'orderId' => $order->id,
                        'coin' => $order->cur_from,
                        'amount' => $row['amount'],
                        'txid' => $row['txID'],
                        'status' => $row['status'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    if ($depId) {
                        $this->repository->updateOrderStatus($order->id, config('app.ORDER_STATUS_PAID'));
                        break 2;
                    }
                }

            }
        }
    }

}
