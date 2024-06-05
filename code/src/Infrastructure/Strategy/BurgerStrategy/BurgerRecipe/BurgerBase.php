<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\BurgerStrategy\BurgerRecipe;

use App\Application\Interface\RecipeInterface;

Abstract class BurgerBase implements RecipeInterface
{
    protected ?string $recipe = 'Булочка с кунжутом';

    abstract protected function assembleBurger(): string;
    public function getRecipe(): string
    {
        return $this->recipe;
    }

}