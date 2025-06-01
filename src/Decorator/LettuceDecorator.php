<?php

declare(strict_types=1);

namespace App\Decorator;

use App\FoodItem\FoodItemInterface;

class LettuceDecorator extends FoodDecorator
{
    /**
     * LettuceDecorator constructor.
     */
    public function prepare(): void
    {
        parent::prepare();
        echo "Adding lettuce\n";
    }

    /**
     * Get the description of the food item with lettuce.
     *
     * @return string The description of the food item with lettuce.
     */
    public function getDescription(): string
    {
        return parent::getDescription() . ", Lettuce";
    }

    /**
     * Get the price of the food item with lettuce.
     *
     * @return float The price of the food item with lettuce.
     */
    public function getPrice(): float
    {
        return parent::getPrice() + 0.50;
    }
}
