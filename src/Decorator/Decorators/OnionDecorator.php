<?php

namespace VladimirGrinko\Patterns\Decorator\Decorators;

class OnionDecorator extends IngredientDecorator
{
    const PRICE = 5;

    public function getDescription(): string
    {
        return $this->product->getDescription() . ', лук';
    }

    public function getCost(): float
    {
        return $this->product->getCost() + self::PRICE;
    }
}