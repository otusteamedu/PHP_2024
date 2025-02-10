<?php

declare(strict_types=1);

namespace Domain\Strategies;

use Domain\Strategies\ProductStrategyInterface;

class BurgerStrategy implements ProductStrategyInterface
{
    public function createProduct(): string
    {
        return 'Burger';
    }
}
