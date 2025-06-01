<?php

namespace App\Strategy;

use App\FoodItem\FoodItemInterface;
use App\FoodItem\Sandwich;

class SandwichStrategy implements FoodStrategyInterface
{
    public function createBaseProduct(): FoodItemInterface
    {
        return new Sandwich();
    }
}
