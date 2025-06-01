<?php

declare(strict_types=1);

namespace App\Factory;

interface FoodProcessorCreatorInterface
{
    /**
     * Create a food processor.
     *
     * @return FoodProcessorInterface The food processor instance.
     */
    public function createFoodProcessor(): FoodProcessorInterface;
}
