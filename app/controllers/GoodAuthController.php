<?php


namespace App\controllers;


use App\main\AppCall;

class GoodAuthController extends CRUDController
{
    public $nameSingle = "goodAuth";
    public $namePlr = "goodsAuth";

    public function getRepository(): object
    {
        return AppCall::call()->goodAuthRepository;
    }

    public function getService(): object
    {
        return AppCall::call()->goodService;
    }
}