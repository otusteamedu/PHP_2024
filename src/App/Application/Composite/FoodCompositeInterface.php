<?php

namespace App\Application\Composite;

interface FoodCompositeInterface
{
    public function composite(FoodCompositeRequest $food): FoodCompositeResponse;
}