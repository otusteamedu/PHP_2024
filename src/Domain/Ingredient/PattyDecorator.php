<?php

declare(strict_types=1);

namespace App\Domain\Ingredient;

use App\Domain\Product\{AbstractProduct, HasCompositionInterface};

class PattyDecorator extends AbstractDecorator
{
    public function __construct(private AbstractProduct $product) {}

    public function getProduct(): HasCompositionInterface
    {
        return $this->product->addIngredient(new Patty());
    }
}
