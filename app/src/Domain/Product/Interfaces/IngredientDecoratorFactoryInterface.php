<?php

namespace AnatolyShilyaev\App\Domain\Product\Interfaces;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

interface IngredientDecoratorFactoryInterface
{
    public function decorate(Product $product, string $ingredient): Product;
}
