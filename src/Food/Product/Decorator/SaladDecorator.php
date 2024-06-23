<?php

declare(strict_types=1);

namespace App\Food\Product\Decorator;

use App\Exception\InvalidArgumentException;
use App\Food\Ingredient;
use App\Food\Product\Composite\ProductInterface;
use App\ObjectValue\Money;

class SaladDecorator extends ProductDecorator
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(ProductInterface $product)
    {
        parent::__construct($product);
        $this->addAdditionIngredient(new Ingredient('Салат', new Money(50)));
    }
}
