<?php

namespace Irayu\Hw16\Domain\Processes;

use Irayu\Hw16\Domain\Dish\DishFactory;
use Irayu\Hw16\Domain\Dish\Dish;

interface PreparationStrategy
{
    public function prepare(DishFactory $factory): Dish;
}
