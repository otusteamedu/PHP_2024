<?php

namespace Interfaces\Products;

use Ingredients\IngredientInterface;

interface WithIngredients
{
    public function addIngredient(IngredientInterface $ingredient): void;

    public function addIngredients(IngredientInterface ...$ingredients): void;

    /**
     * @return IngredientInterface[]
     */
    public function getIngredients(): array;
}