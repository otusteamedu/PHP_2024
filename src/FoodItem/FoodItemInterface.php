<?php

declare(strict_types=1);

namespace App\FoodItem;

/**
 * Interface FoodItemInterface
 *
 * This interface defines the methods that any food item should implement.
 */
interface FoodItemInterface
{
    /**
     * Prepare the food item.
     *
     * This method should contain the logic to prepare the food item.
     *
     * @return void
     */
    public function prepare(): void;

    /**
     * Get the description of the food item.
     *
     * This method should return a string describing the food item.
     *
     * @return string The description of the food item.
     */
    public function getDescription(): string;

    /**
     * Get the price of the food item.
     *
     * This method should return a float representing the price of the food item.
     *
     * @return float The price of the food item.
     */
    public function getPrice(): float;
}
