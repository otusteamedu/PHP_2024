<?php

namespace App\Infrastructure\Repository;

use App\Application\Interface\Repository;
use App\Domain\Entity\OrderEntity;
use App\Models\Order;

class DbWorkflow implements Repository
{

    public function save(OrderEntity $order)
    {
        return Order::create([
            'status' => $order->getStatus(),
            'cur_from' => $order->getCurFrom(),
            'cur_to' => $order->getCurTo(),
            'amount_from' => $order->getAmountFrom(),
            'amount_to' => $order->getAmountTo(),
            'rateFrom' => $order->getRateFrom(),
            'rateTo' => $order->getRateTo(),
            'email' => $order->getEmail(),
            'recipient_account' => $order->getRecipientAccount(),
        ]);

//        $orderModel = new Order;
//
//        $orderModel->status = $order->getStatus();
//        $orderModel->cur_from = $order->getCurFrom();
//        $orderModel->cur_to = $order->getCurTo();
//        $orderModel->amount_from = $order->getAmountFrom();
//        $orderModel->amount_to = $order->getAmountTo();
//        $orderModel->rate = $order->getRate();
//        $orderModel->save();

//        return new DTO(
//            $this->order->getStatus(),
//            $this->order->getCurFrom(),
//            $this->order->getCurTo(),
//            $this->order->getAmountFrom(),
//            $this->order->getAmountTo(),
//            $this->order->getRate()
//        );

    }


    public function updateOrderStatus($orderId, $status)
    {
        // TODO: Implement updateOrderStatus() method.
    }


}
