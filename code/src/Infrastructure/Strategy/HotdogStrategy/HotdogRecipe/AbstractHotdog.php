<?php
declare(strict_types=1);

namespace App\Infrastructure\Strategy\HotdogStrategy\HotdogRecipe;

use App\Application\Interface\RecipeInterface;

Abstract class AbstractHotdog implements RecipeInterface
{
    protected ?string $recipe = 'Булочка для хотдога, ';

    abstract protected function assembleBurger(): void;
    public function getRecipe(): string
    {
        return $this->recipe;
    }

}