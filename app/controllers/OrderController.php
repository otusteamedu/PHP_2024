<?php


namespace App\controllers;

use App\main\AppCall;
use App\modules\Order;

class OrderController extends CRUDController
{
    public $nameSingle = "order";
    public $namePlr = "orders";

    public function getRepository(): object
    {
        return AppCall::call()->orderRepository;
    }

    public function getService(): object
    {
        return AppCall::call()->orderService;
    }

    public function oneAction()
    {
        $order = ($this->repository->getOrder($this->getId()));;

        return $this->render("$this->nameSingle", [
            "$this->nameSingle" => $order,
            "products" => $order->order_list,
        ]);
    }
}