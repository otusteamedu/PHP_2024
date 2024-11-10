<?php

declare(strict_types=1);

namespace Irayu\Hw16\Domain\Dish;

interface DishFactory
{
    public function createProduct(): Dish;
}
