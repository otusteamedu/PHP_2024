<?php

declare(strict_types=1);

namespace Domain\Strategies;

use Domain\Entities\Product;

interface ProductStrategyInterface
{
    public function createProduct(): Product;
}
