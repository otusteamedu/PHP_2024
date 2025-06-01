<?php

declare(strict_types=1);

namespace App\Decorator;

use App\FoodItem\FoodItemInterface;

class CheeseDecorator extends FoodDecorator
{
    /**
     * CheeseDecorator constructor.
     */
    public function prepare(): void
    {
        parent::prepare();
        echo "Adding cheese\n";
    }

    /**
     * Get the description of the food item with cheese.
     *
     * @return string The description of the food item with cheese.
     */
    public function getDescription(): string
    {
        return parent::getDescription() . ", Cheese";
    }

    /**
     * Get the price of the food item with cheese.
     *
     * @return float The price of the food item with cheese.
     */
    public function getPrice(): float
    {
        return parent::getPrice() + 1.00;
    }
}
