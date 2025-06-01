<?php

declare(strict_types=1);

namespace App\Decorator;

use App\FoodItem\FoodItemInterface;

class OnionDecorator extends FoodDecorator
{
    /**
     * OnionDecorator constructor.
     */
    public function prepare(): void
    {
        parent::prepare();
        echo "Adding onions\n";
    }

    /**
     * Get the description of the food item with onions.
     *
     * @return string The description of the food item with onions.
     */
    public function getDescription(): string
    {
        return parent::getDescription() . ", Onion";
    }

    /**
     * Get the price of the food item with onions.
     *
     * @return float The price of the food item with onions.
     */
    public function getPrice(): float
    {
        return parent::getPrice() + 0.30;
    }
}
