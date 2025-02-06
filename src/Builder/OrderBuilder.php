<?php

namespace VladimirGrinko\Patterns\Builder;

use VladimirGrinko\Patterns\Decorator\ProductInterface;

class OrderBuilder
{
    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function addProduct(ProductInterface $product): OrderBuilder
    {
        $this->order->addProduct($product);
        return $this;
    }

    public function build(): Order
    {
        return $this->order;
    }
}
