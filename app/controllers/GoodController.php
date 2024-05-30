<?php


namespace App\controllers;


use App\main\AppCall;
use App\modules\Good;
use App\modules\User;

class GoodController extends CRUDController
{
    public $nameSingle = "good";
    public $namePlr = "goods";

    public function getRepository(): object
    {
        return AppCall::call()->goodRepository;
    }

    public function getService(): object
    {
        return AppCall::call()->goodService;
    }
}