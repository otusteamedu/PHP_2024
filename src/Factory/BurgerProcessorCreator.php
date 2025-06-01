<?php

declare(strict_types=1);

namespace App\Factory;

class BurgerProcessorCreator implements FoodProcessorCreatorInterface
{
    /**
     * Create a burger processor.
     *
     * @return FoodProcessorInterface The burger processor instance.
     */
    public function createFoodProcessor(): FoodProcessorInterface
    {
        return new BurgerProcessor();
    }
}
