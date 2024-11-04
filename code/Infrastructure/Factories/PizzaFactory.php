<?php

declare(strict_types=1);

namespace Infrastructure\Factories;

use Domain\Adapters\PizzaAdapter;
use Domain\Entities\Pizza;
use Domain\Entities\Product;
use Domain\Factories\ProductFactoryInterface;

class PizzaFactory implements ProductFactoryInterface
{
    public function createProduct(): Product
    {
        return new PizzaAdapter(new Pizza());
    }
}
