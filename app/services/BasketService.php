<?php


namespace App\services;

use App\main\AppCall;

class BasketService extends CRUDService
{
    public function getProduct ($id){

         $product = (AppCall::call()->goodRepository)->getOne($id);
         $product = (array)$product;
         $product["goods_id"]= $product["id"];
         unset($product["id"]);
         return $product;

    }


    public function hasErrors($params)
    {
        return false;
    }
}