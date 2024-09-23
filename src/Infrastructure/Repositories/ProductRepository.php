<?php

use App\Domain\Entities\Order;
use App\Domain\Entities\Products\ProductInterface;
use App\Domain\Repositories\OrderRepositoryInterface;
use App\Domain\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getProducts(Order $order): array
    {
        /**
         * @var ProductInterface[] $products
         */
        static $products;

        if (!isset($products)) {
            // todo: $products = забрать из дб и присвоить
        }
    }
}