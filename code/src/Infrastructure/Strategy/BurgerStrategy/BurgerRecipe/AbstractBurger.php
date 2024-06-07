<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

use App\Application\Interface\RecipeInterface;

Abstract class AbstractBurger implements RecipeInterface
{
    protected ?string $recipe = 'Булочка с кунжутом, ';

    abstract protected function assembleBurger(): void;
    public function getRecipe(): string
    {
        return $this->recipe;
    }

}