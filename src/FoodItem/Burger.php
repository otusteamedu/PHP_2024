<?php

declare(strict_types=1);

namespace App\FoodItem;

class Burger implements FoodItemInterface
{
    /**
     * Prepare the burger.
     *
     * This method simulates the preparation of a basic burger.
     */
    public function prepare(): void
    {
        echo "Preparing basic burger\n";
    }

    /**
     * Get the description of the burger.
     *
     * @return string The description of the burger.
     */
    public function getDescription(): string
    {
        return "Basic Burger";
    }

    /**
     * Get the price of the burger.
     *
     * @return float The price of the burger.
     */
    public function getPrice(): float
    {
        return 5.99;
    }
}
