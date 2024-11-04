<?php

declare(strict_types=1);

namespace Domain\Decorators;

use Domain\Entities\Product;

abstract class AbstractProductDecorator extends Product
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getIngredients(): array
    {
        return array_merge($this->product->getIngredients(), $this->ingredients);
    }
}
