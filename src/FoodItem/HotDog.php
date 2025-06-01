<?php

declare(strict_types=1);

namespace App\FoodItem;

class HotDog implements FoodItemInterface
{
    /**
     * Prepare the hot dog.
     *
     * This method simulates the preparation of a basic hot dog.
     */
    public function prepare(): void
    {
        echo "Preparing basic hot dog\n";
    }

    /**
     * Get the description of the hot dog.
     *
     * @return string The description of the hot dog.
     */
    public function getDescription(): string
    {
        return "Basic Hot Dog";
    }

    /**
     * Get the price of the hot dog.
     *
     * @return float The price of the hot dog.
     */
    public function getPrice(): float
    {
        return 3.99;
    }
}
