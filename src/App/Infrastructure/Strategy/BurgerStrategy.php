<?php

namespace App\Infrastructure\Strategy;

use App\Application\Strategy\Strategy;
use App\Domain\Entity\Burger;
use App\Domain\Entity\FoodComposite;

class BurgerStrategy implements Strategy
{
    public function generateNewFood(string $name): FoodComposite
    {
        return new Burger($name);
    }
}