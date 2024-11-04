<?php

declare(strict_types=1);

namespace Infrastructure\Factories;

use Domain\Entities\Burger;
use Domain\Entities\Product;
use Domain\Factories\ProductFactoryInterface;

class BurgerFactory implements ProductFactoryInterface
{
    public function createProduct(): Product
    {
        return new Burger();
    }
}
