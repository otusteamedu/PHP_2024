<?php

namespace App\Infrastructure\Strategy;

use App\Application\Strategy\Strategy;
use App\Domain\Entity\FoodComposite;
use App\Domain\Entity\Sandwich;

class SandwichStrategy implements Strategy
{
    public function generateNewFood(string $name): FoodComposite
    {
        return new Sandwich($name);
    }
}