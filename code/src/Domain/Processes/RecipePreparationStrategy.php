<?php

declare(strict_types=1);

namespace Irayu\Hw16\Domain\Processes;

use Irayu\Hw16\Domain\Dish\DishFactory;
use Irayu\Hw16\Domain\Dish\Dish;

class RecipePreparationStrategy implements PreparationStrategy
{
    public function prepare(DishFactory $factory): Dish
    {
        return $factory->createProduct();
    }
}
