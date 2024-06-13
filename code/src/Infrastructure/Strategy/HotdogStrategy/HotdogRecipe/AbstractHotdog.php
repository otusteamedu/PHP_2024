<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\HotdogStrategy\HotdogRecipe;

use App\Application\Interface\RecipeInterface;

Abstract class AbstractHotdog implements RecipeInterface
{
    protected ?string $recipe = 'Булочка для хотдога, ';

    protected function assembleHotdog
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