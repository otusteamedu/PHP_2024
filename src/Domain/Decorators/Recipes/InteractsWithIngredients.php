<?php

namespace App\Domain\Decorators\Recipes;

use App\Domain\Entities\Ingredients\IngredientInterface;

interface InteractsWithIngredients
{
    public function addIngredient(IngredientInterface $ingredient): void;

    public function addIngredients(IngredientInterface ...$ingredients): void;
}
