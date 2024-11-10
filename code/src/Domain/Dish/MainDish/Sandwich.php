<?php

declare(strict_types=1);

namespace Irayu\Hw16\Domain\Dish\MainDish;

use Irayu\Hw16\Domain\Dish\Dish;

class Sandwich implements Dish
{
    public function getDescription(): string
    {
        return "Базовый сэндвич";
    }
}
