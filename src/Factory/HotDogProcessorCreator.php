<?php

declare(strict_types=1);

namespace App\Factory;

class HotDogProcessorCreator implements FoodProcessorCreatorInterface
{
    /**
     * Create a hot dog processor.
     *
     * @return FoodProcessorInterface The hot dog processor instance.
     */
    public function createFoodProcessor(): FoodProcessorInterface
    {
        return new HotDogProcessor();
    }
}
