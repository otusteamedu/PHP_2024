<?php

declare(strict_types=1);

namespace Domain\Strategies;

use Domain\Strategies\ProductStrategyInterface;

class SandwichStrategy implements ProductStrategyInterface
{
    public function createProduct(): string
    {
        return 'Sandwich';
    }
}
