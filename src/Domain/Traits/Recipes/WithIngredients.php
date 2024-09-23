<?php

namespace App\Domain\Traits\Products;

use App\Domain\Entities\Ingredients\IngredientInterface;

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