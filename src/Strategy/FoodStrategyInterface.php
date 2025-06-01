<?php

namespace App\Strategy;

use App\FoodItem\FoodItemInterface;

interface FoodStrategyInterface
{
    public function createBaseProduct(): FoodItemInterface;
}
