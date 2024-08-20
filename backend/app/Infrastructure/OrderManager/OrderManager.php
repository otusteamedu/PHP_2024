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
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JsonException;
use PhpParser\Builder\Class_;
use RuntimeException;

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

    /**
     * @throws JsonException
     */
    private function orderPaid($order): void
    {
        $this->repository->updateOrderStatus($order->id, config('app.ORDER_STATUS_PAID'));
        Log::debug("Status has been updated");
        $txid = $this->orderMakePayment($order->id, $order->recipient_account, $order->amount_to);
        Log::debug("Making payment ...");
        if (!is_null($txid)) {
            Log::debug("Got transaction: " . $txid);
            $this->orderComplete($order->id, $txid);
        }
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

    private function orderComplete($orderId, $txid): void
    {
        $this->repository->updateRow(Order::getTableName(),$orderId, [
            'withdraw_txid' => $txid,
            'status' => config('app.ORDER_STATUS_COMPLETED'),
        ]);
        Log::debug("Complete order!");
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
            if (Carbon::parse(now()) > $dt->addSeconds($this->orderLifetime)) {
                continue;
            }
            $orders[] = $order;
        }

        return $orders;
    }

    /**
     * @throws JsonException
     */
    public function checkOrderCryptoDeposit(): void
    {
        $awaitOrders = $this->getAwaitCryptoOrders();
        foreach ($awaitOrders as $order) {
            Log::debug("Check deposit", [$order]);
            $currency = explode('_',$order->cur_from);
            $coin = $currency[0];
            $chain = $currency[1];
            $startTime = Carbon::parse($order->created_at)->timestamp;
            $endTime = ($startTime + $this->orderLifetime);
            $json = $this->paymentManager->checkCryptoDeposit(strtoupper($coin), $startTime, $endTime);

            $json = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            // Validate and update order status if conditions are met
            foreach ($json['result']['rows'] as $row) {
                Log::debug("Check deposit", [$row]);
                if (
                    $row['status'] === config('app.CRYPTO_DEPOSIT_ACCEPTED') &&
                    $row['chain'] === $this->paymentManager->cryptoManager->chains[$chain] &&
                    (float)$row['amount'] === (float)number_format($order->amount_from, 2) &&
                    !count($this->repository->getRowsWhere(CryptoDeposit::getTableName(),'txid', $row['txID']))
                ) {
                    Log::debug("Conditions have passed");
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
                        $this->orderPaid($order);
                        break 2;
                    }
                }

            }
        }
    }

    /**
     * @throws RuntimeException|JsonException
     */
    private function orderMakePayment($orderId, $recipient_account, $amount_to)
    {
        // Implementation to make payment
        try {
            Log::debug("Попали в orderMakePayment");
            $res = $this->paymentManager->fiatManager->makePayment($recipient_account, $amount_to);
            return $res;
        } catch (\RuntimeException $e) {
            Log::error("Payment failed", ['message' => $e->getMessage(), 'order_id' => $orderId]);
            throw new \RuntimeException("Payment failed");
        }
        # '{"return":"7bd01cf6-0c0c-40e8-8f9f-2017d6dd2695"}'

    }

    public function test()
    {
        return 'response: ' . $this->orderMakePayment(3, 'U431122090131', '');
    }

}
