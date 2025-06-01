<?php

declare(strict_types=1);

namespace App\Decorator;

use App\FoodItem\FoodItemInterface;

abstract class FoodDecorator implements FoodItemInterface
{
    /**
     * The food item to be decorated.
     *
     * @var FoodItemInterface
     */
    protected FoodItemInterface $foodItem;

    /**
     * FoodDecorator constructor.
     *
     * @param FoodItemInterface $foodItem The food item to be decorated.
     */
    public function __construct(FoodItemInterface $foodItem)
    {
        $this->foodItem = $foodItem;
    }

    /**
     * Prepare the food item.
     *
     * This method calls the prepare method of the decorated food item.
     */
    public function prepare(): void
    {
        $this->foodItem->prepare();
    }

    /**
     * Get the description of the food item.
     *
     * This method calls the getDescription method of the decorated food item.
     *
     * @return string The description of the food item.
     */
    public function getDescription(): string
    {
        return $this->foodItem->getDescription();
    }

    /**
     * Get the price of the food item.
     *
     * This method calls the getPrice method of the decorated food item.
     *
     * @return float The price of the food item.
     */
    public function getPrice(): float
    {
        return $this->foodItem->getPrice();
    }
}
