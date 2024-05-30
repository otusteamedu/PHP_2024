<?php


namespace App\controllers;


use App\main\AppCall;
use App\services\renders\IRender;
use App\services\Request;

class OrderAuthController extends OrderController
{
    public $nameSingle = "orderAuth";
    public $namePlr = "ordersAuth";

    public function getRepository(): object
    {
        return AppCall::call()->orderAuthRepository;
    }

    public function getService(): object
    {
        return AppCall::call()->orderService;
    }

    public function allAction()
    {
        return $this->render("$this->namePlr", [
            "$this->namePlr" => $this->repository->getAllOrders($this->request->session("user"))
        ]);
    }

    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->render('createOrder');
        }

        if ($this->isPost()) {
            $userId = $this->request->get("userId");
            $params = $this->request->post();
            $params["user_id"] = $userId;
            $saveOrder = ($this->service)->fill($params, $this->repository, $this->request);

            if ($saveOrder) {
                $productsInBasket = $this->request->session("order_list");
                $OrderId = $this->repository->bd->lastInsertId();

                foreach ($productsInBasket as $product => $values) {
                    $values['user_id'] = $userId;
                    $values['order_id'] = $OrderId;
                    $this->request->setSession("order_list", $values, $product);
                }
                header('location:/basket/updateOrderList');
            }

        }
    }
}