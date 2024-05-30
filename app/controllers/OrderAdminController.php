<?php


namespace App\controllers;


use App\main\AppCall;

class OrderAdminController extends OrderController
{
    public $nameSingle = "orderAdmin";
    public $namePlr = "ordersAdmin";

    public function getRepository(): object
    {
        return AppCall::call()->orderAdminRepository;
    }

    public function getService(): object
    {
        return AppCall::call()->orderService;
    }

    public function updateAction()
    {
        if (empty($this->getId())) {
            return header("Location: /$this->nameSingle");
        }
        $order = ($this->repository->getOrder($this->getId()));

        if ($this->isPost()) {
            $orderParams = $this->request->post();
            unset($orderParams["order_list"]);
            $this->service->fill($orderParams, $this->repository, $this->request, $order);

            $order_list = $this->request->post("order_list");
            foreach ($order_list as $item => $value) {
                $item = [
                    "order_id" => $this->request->get("id"),
                    "goods_id" => $item,
                    "count" => $value
                ];
                $product = (object)$item;
                $this->repository->updateOrderList($product);

            }
            return header("Location: /$this->nameSingle");
        }

        return $this->render("$this->nameSingle" . 'Update', [
            "$this->nameSingle" => $order,
            "products" => $order->order_list,
        ]);
    }

}