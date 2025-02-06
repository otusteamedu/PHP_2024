<?php

namespace VladimirGrinko\Patterns\Decorator\Decorators;

use VladimirGrinko\Patterns\Decorator\{
    ProductInterface
};

abstract class IngredientDecorator implements ProductInterface
{
    protected ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    abstract public function getDescription(): string;
    abstract public function getCost(): float;
}
