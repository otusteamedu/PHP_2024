<?php

declare(strict_types=1);

namespace App\Factory;

class SandwichProcessorCreator implements FoodProcessorCreatorInterface
{
    /**
     * Create a sandwich processor.
     *
     * @return FoodProcessorInterface The sandwich processor instance.
     */
    public function createFoodProcessor(): FoodProcessorInterface
    {
        return new SandwichProcessor();
    }
}
