<?php

declare(strict_types=1);

namespace Irayu\Hw16\Domain\Dish\MainDish;

use Irayu\Hw16\Domain\Dish\Dish;
use Irayu\Hw16\Domain\Dish\DishFactory;

class HotDogFactory implements DishFactory
{
    public function createProduct(): Dish
    {
        return new HotDog();
    }
}
