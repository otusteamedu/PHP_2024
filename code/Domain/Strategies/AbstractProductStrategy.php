<?php

declare(strict_types=1);

namespace Domain\Strategies;

use Domain\Entities\Product;
use Domain\Factories\ProductFactoryInterface;

class AbstractProductStrategy implements ProductStrategyInterface
{
    private ProductFactoryInterface $factory;

    public function __construct(ProductFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createProduct(): Product
    {
        return $this->factory->createProduct();
    }
}
