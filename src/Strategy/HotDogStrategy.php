<?php

namespace App\Strategy;

use App\FoodItem\FoodItemInterface;
use App\FoodItem\HotDog;

class HotDogStrategy implements FoodStrategyInterface
{
    public function createBaseProduct(): FoodItemInterface
    {
        return new HotDog();
    }
}
