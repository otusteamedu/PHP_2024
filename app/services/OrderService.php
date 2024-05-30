<?php


namespace App\services;


use App\entities\Good;

class OrderService extends CRUDService
{

    public function hasErrors($params)
    {
        return false;
    }

}