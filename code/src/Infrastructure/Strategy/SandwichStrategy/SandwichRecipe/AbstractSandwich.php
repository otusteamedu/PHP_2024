<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\SandwichStrategy\SandwichRecipe;

use App\Application\Interface\RecipeInterface;

Abstract class AbstractSandwich implements RecipeInterface
{
    protected ?string $recipe = 'Минибатон с кунжутом, ';

    protected function assembleSandwich
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