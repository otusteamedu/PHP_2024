<?php
declare(strict_types=1);

namespace App\Infrastructure\Recipe\BurgerRecipe;

use App\Infrastructure\Recipe\Interface\RecipeInterface;

Abstract class StandartBurgerRecipe implements RecipeInterface
{
    private string $recipe;

    public function __construct()
    {
        $this->recipe = 'Булочка с кунжутом, говяжья котлета, бургерный соус';
    }

    public function getRecipe(): string
    {
        return $this->recipe;
    }

    public function setRecipe(array $ingredients): void
    {
        foreach ($ingredients as $ingredient) {
            $this->recipe.= ', '.$ingredient;
        }
    }
}