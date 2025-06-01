<?php

declare(strict_types=1);

namespace App\Factory;

use App\FoodItem\FoodItemInterface;

class SandwichProcessor implements FoodProcessorInterface
{
    /**
     * Process a sandwich item.
     *
     * @param FoodItemInterface $item The food item to process.
     * @return FoodItemInterface The processed food item.
     */
    public function process(FoodItemInterface $item): FoodItemInterface
    {
        echo "Pre-processing sandwich: toasting bread\n";
        $item->prepare();
        echo "Post-processing sandwich: cutting in half\n";

        return $item;
    }
}
