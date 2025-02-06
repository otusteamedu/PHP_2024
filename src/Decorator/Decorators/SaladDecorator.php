<?php

namespace VladimirGrinko\Patterns\Decorator\Decorators;

class SaladDecorator extends IngredientDecorator
{
    const PRICE = 10;

    public function getDescription(): string
    {
        return $this->product->getDescription() . ', салат';
    }

    public function getCost(): float
    {
        return $this->product->getCost() + self::PRICE;
    }
}