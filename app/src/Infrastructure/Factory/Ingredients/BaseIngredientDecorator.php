<?php

namespace AnatolyShilyaev\App\Infrastructure\Factory\Ingredients;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

abstract class BaseIngredientDecorator extends Product
{
    public function __construct(
        protected Product $product
    ) {}

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getIngredients(): array
    {
        return $this->product->getIngredients();
    }
}
