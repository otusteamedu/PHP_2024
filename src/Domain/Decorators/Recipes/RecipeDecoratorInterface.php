<?php

namespace App\Domain\Decorators\Recipes;

use App\Domain\Entities\Products\ProductInterface;

interface RecipeDecoratorInterface
{
    public function __construct(ProductInterface $product);
}