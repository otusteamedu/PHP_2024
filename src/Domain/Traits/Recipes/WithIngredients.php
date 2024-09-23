<?php

namespace Traits\Recipes;

use Ingredients\IngredientInterface;
use ProductInterface;

trait WithIngredients
{
    protected ProductInterface $product;

    public function addIngredient(IngredientInterface $ingredient): void
    {
        $this->product->addIngredient($ingredient);
    }

    public function addIngredients(IngredientInterface ...$ingredients): void
    {
        $this->product->addIngredients(...$ingredients);
    }
}