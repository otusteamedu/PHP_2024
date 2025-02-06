<?php

namespace VladimirGrinko\Patterns\Builder;

use VladimirGrinko\Patterns\Decorator\ProductInterface;

class Order
{
    private $products = [];

    public function addProduct(ProductInterface $product): void
    {
        $this->products[] = $product;
    }

    public function getDescription(): string
    {
        $description = "Заказ:\n";
        foreach ($this->products as $product) {
            $description .= $product->getDescription() . " - $" . $product->getCost() . "\n";
        }
        return $description;
    }
}
