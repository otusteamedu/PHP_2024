<?php

namespace App\Strategy;

use App\FoodItem\FoodItemInterface;
use App\FoodItem\Burger;

class BurgerStrategy implements FoodStrategyInterface
{
    public function createBaseProduct(): FoodItemInterface
    {
        return new Burger();
    }
}

