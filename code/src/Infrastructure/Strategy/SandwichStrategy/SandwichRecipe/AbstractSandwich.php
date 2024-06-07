<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\SandwichStrategy\SandwichRecipe;

use App\Application\Interface\RecipeInterface;

Abstract class AbstractSandwich implements RecipeInterface
{
    protected ?string $recipe = 'Минибатон с кунжутом, ';

    abstract protected function assembleBurger(): void;
    public function getRecipe(): string
    {
        return $this->recipe;
    }

}