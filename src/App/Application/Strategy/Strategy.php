<?php

namespace App\Application\Strategy;

use App\Domain\Entity\FoodComposite;

interface Strategy
{
    public function generateNewFood(string $name): FoodComposite;
}