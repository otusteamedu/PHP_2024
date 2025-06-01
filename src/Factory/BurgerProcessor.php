<?php

declare(strict_types=1);

namespace App\Factory;

use App\FoodItem\FoodItemInterface;

class BurgerProcessor implements FoodProcessorInterface
{
    /**
     * Process a burger item.
     *
     * @param FoodItemInterface $item The food item to process.
     * @return FoodItemInterface The processed food item.
     */
    public function process(FoodItemInterface $item): FoodItemInterface
    {
        echo "Pre-processing burger: heating the grill\n";
        $item->prepare();
        echo "Post-processing burger: wrapping in paper\n";

        return $item;
    }
}
