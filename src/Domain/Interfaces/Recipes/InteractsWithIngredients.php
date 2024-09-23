<?php

namespace Interfaces\Recipes;

use Ingredients\IngredientInterface;

interface InteractsWithIngredients
{
    public function addIngredient(IngredientInterface $ingredient): void;

    public function addIngredients(IngredientInterface ...$ingredients): void;
}