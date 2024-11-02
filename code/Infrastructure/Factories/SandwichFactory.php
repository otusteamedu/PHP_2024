<?php

declare(strict_types=1);

namespace Infrastructure\Factories;

use Domain\Entities\Product;
use Domain\Entities\Sandwich;
use Domain\Factories\ProductFactoryInterface;

class SandwichFactory implements ProductFactoryInterface
{
    public function createProduct(): Product
    {
        return new Sandwich();
    }
}
