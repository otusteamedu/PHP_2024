<?php

namespace App\Strategy;

use App\FoodItem\FoodItemInterface;

class FoodContext
{
    private FoodStrategyInterface $strategy;

    public function __construct(FoodStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(FoodStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function createFood(): FoodItemInterface
    {
        return $this->strategy->createBaseProduct();
    }
}
