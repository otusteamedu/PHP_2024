<?php

declare(strict_types=1);

namespace App\Factory;

use App\FoodItem\FoodItemInterface;

class HotDogProcessor implements FoodProcessorInterface
{
    /**
     * Process a hot dog item.
     *
     * @param FoodItemInterface $item The food item to process.
     * @return FoodItemInterface The processed food item.
     */
    public function process(FoodItemInterface $item): FoodItemInterface
    {
        echo "Pre-processing hot dog: steaming the bun\n";
        $item->prepare();
        echo "Post-processing hot dog: adding condiment packets\n";

        return $item;
    }
}
