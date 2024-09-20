<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\Meal;

interface MealFactoryInterface
{
    public function createMeal(string $type): Meal;
}
