<?php

namespace VladimirGrinko\Patterns\Decorator\Decorators;

class PepperDecorator extends IngredientDecorator
{
    const PRICE = 7;

    public function getDescription(): string
    {
        return $this->product->getDescription() . ', перец';
    }

    public function getCost(): float
    {
        return $this->product->getCost() + self::PRICE;
    }
}