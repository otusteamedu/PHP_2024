<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Burger;
use App\Domain\Entity\HotDog;
use App\Domain\Entity\Meal;
use App\Domain\Entity\Sandwich;
use App\Domain\Factory\MealFactoryInterface;

class MealFactory implements MealFactoryInterface
{
    public function createMeal(string $type): Meal
    {
        return match ($type) {
            'burger' => new Burger(),
            'hotdog' => new HotDog(),
            'sandwich' => new Sandwich(),
            default => throw new \InvalidArgumentException('Unknown meal type'),
        };
    }
}
