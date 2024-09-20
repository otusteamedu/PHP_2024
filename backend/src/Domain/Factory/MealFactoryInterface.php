<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\Burger;
use App\Domain\Entity\HotDog;
use App\Domain\Entity\Meal;
use App\Domain\Entity\Sandwich;

class MealFactory
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
