<?php

declare(strict_types=1);

namespace App\Factory;

use App\FoodItem\FoodItemInterface;

interface FoodProcessorInterface
{
    /**
     * Process a food item.
     *
     * @param FoodItemInterface $item The food item to process.
     * @return FoodItemInterface The processed food item.
     */
    public function process(FoodItemInterface $item): FoodItemInterface;
}
