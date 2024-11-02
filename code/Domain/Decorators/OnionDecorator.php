<?php

declare(strict_types=1);

namespace Domain\Decorators;

use Domain\Entities\Product;
use Domain\ValueObjects\Ingredient;

class OnionDecorator extends AbstractProductDecorator
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->addIngredient(new Ingredient('Onion'));
    }

    public function getDescription(): string
    {
        return $this->product->getDescription() . ", Onion";
    }
}
