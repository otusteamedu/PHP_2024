<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository;
use App\Domain\Entity\OrderEntity;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DbWorkflow implements Repository
{

    public function save(OrderEntity $order): int
    {
        return DB::table('orders')->insertGetId([
            'status' => $order->getStatus(),
            'cur_from' => $order->getCurFrom(),
            'cur_to' => $order->getCurTo(),
            'amount_from' => $order->getAmountFrom(),
            'amount_to' => $order->getAmountTo(),
            'rateFrom' => $order->getRateFrom(),
            'rateTo' => $order->getRateTo(),
            'email' => $order->getEmail(),
            'recipient_account' => $order->getRecipientAccount(),
            'incoming_asset' => $order->getIncomingAsset(),
        ]);
    }

    public function getRowById($id)
    {
        return Order::find($id);
    }

    public function updateOrderStatus($orderId, $status): void
    {
        try {
            DB::table('orders')
                ->where('id', $orderId)
                ->update(['status' => $status]);
        } catch (\PDOException $e) {
            // Handle exception
            throw new \Exception('Error updating order status');
        }
    }


    public function getCurType(string $cur)
    {
        return DB::table('currencies')
            ->where('code', $cur)
            ->value('type');
    }
}
