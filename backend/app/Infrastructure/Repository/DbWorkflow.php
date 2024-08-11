<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository;
use App\Domain\Entity\OrderEntity;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DbWorkflow implements Repository
{

    public function saveOrder(OrderEntity $order): int
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getRowById($id)
    {
        return Order::find($id);
    }

    /**
     * @throws \Exception
     */
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

    public function getRowsWhere(string $table, string $field, $value)
    {
        return DB::table($table)
            ->where($field, $value)
            ->get();
    }

    public function getRowsOrderWhereCurfromIsCrypto($field, $value)
    {
        return DB::table('orders')
            ->join('currencies', 'orders.cur_from', '=', 'currencies.code')
            ->where('currencies.type', 'crypto')
            ->where($field, $value)
            ->select('orders.id','orders.cur_from','orders.amount_from','orders.created_at')
            ->get();
    }

    /**
     * @throws \Exception
     */
    public function save(string $table, array $data)
    {
        return DB::table($table)->insertGetId($data);
    }
}
