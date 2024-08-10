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
        $orders = [];
        $ordersAll = $this->repository->getRowsOrderWhereCurfromIsCrypto('status', self::STATUS_WAITING);

        foreach ($ordersAll as $order) {
            $dt = Carbon::parse($order->created_at);
            if (Carbon::parse(now()) > $dt->addSeconds($this->orderLifetime)) continue;
            $orders[] = $order;
        }

        return $orders;
    }

    public function test()
    {
        return $this->checkOrderCryptoDeposit();

    }

    public function checkOrderCryptoDeposit()
    {
        $awaitOrders = $this->getAwaitCryptoOrders();
        if (!count($awaitOrders)) return 'Записей нет';
        foreach ($awaitOrders as $order) {
            $coin = explode('_',$order->cur_from);
            $startTime = Carbon::parse($order->created_at)->timestamp;
            $endTime = ($startTime + $this->orderLifetime);
            //return $this->paymentManager->checkCryptoDeposit(strtoupper($coin[0]), $startTime, $endTime);
            //return Carbon::createFromTimestamp($st['result']['timeSecond']);
            return ' start - ' . Carbon::createFromTimestamp($startTime) . ' , end - ' . Carbon::createFromTimestamp($endTime) . ' , deposit time - ' . Carbon::createFromTimestamp(1723312277);
            // start - 2024-08-10 18:07:57 , end - 2024-08-10 18:37:57 , deposit time - 2024-08-10 17:51:17
            // start - 1723311346000 , end - 1723311347800000

//            {
//              "retCode":0,
//              "retMsg":"success",
//              "result":{
//                  "rows":[{
//                      "coin":"USDT",
//                      "chain":"TRX",
//                      "amount":"10",
//                      "txID":"859d4324da55e63ced572a513e7e818c1c35aa7b664bf857000908090907ae95",
//                      "status":3,
//                      "toAddress":"TYVDb5TyCj2yTqZkMKKTKZSurkHABMW5PB",
//                      "tag":"",
//                      "depositFee":"",
//                      "successAt":"1723312277000",
//                      "confirmations":"50",
//                      "txIndex":"0",
//                      "blockHash":"0000000003d3f3828c19b793f92caaf3386b254345e728bf73448669a9f58673",
//                      "batchReleaseLimit":"-1",
//                      "depositType":"0"
//                  }],
//                  "nextPageCursor":"eyJtaW5JRCI6OTI4MTIxMjcsIm1heElEIjo5MjgxMjEyN30="
//              },
//              "retExtInfo":{},
//              "time":1723312505919
//          }

        }
    }

}
