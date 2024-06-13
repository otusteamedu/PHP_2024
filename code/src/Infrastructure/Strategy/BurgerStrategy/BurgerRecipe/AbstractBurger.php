<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

use App\Application\Interface\RecipeInterface;

Abstract class AbstractBurger implements RecipeInterface
{
    protected ?string $recipe = 'Булочка с кунжутом, ';

    protected function assembleBurger
    (
        array $ingredients,
        ?string $additional
    ): void
    {
        foreach ($ingredients as $ingredient) {
            $this->recipe.= $ingredient.', ';
        }

        $this->recipe.= $additional?? '';
    }
    public function getRecipe(): string
    {
        return $this->recipe;
    }

}