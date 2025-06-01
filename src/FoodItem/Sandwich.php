<?php

declare(strict_types=1);

namespace App\FoodItem;

class Sandwich implements FoodItemInterface
{
    /**
     * Prepare the sandwich.
     *
     * This method simulates the preparation of a basic sandwich.
     */
    public function prepare(): void
    {
        echo "Preparing basic sandwich\n";
    }

    /**
     * Get the description of the sandwich.
     *
     * @return string The description of the sandwich.
     */
    public function getDescription(): string
    {
        return "Basic Sandwich";
    }

    /**
     * Get the price of the sandwich.
     *
     * @return float The price of the sandwich.
     */
    public function getPrice(): float
    {
        return 4.99;
    }
}
