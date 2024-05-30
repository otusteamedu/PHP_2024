<?php


namespace App\controllers;


use App\main\AppCall;

class GoodAdminController extends CRUDController
{
    public $nameSingle = "goodAdmin";
    public $namePlr = "goodsAdmin";

    public function getRepository()
    {
        return AppCall::call()->goodAdminRepository;
    }

    public function getService()
    {
        return AppCall::call()->goodService;
    }
}