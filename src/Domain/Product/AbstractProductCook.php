<?php

declare(strict_types=1);

namespace App\Domain\Product;

abstract class AbstractProductCook implements CanCookProductInterface
{
    protected array $standartRecipe;

    abstract public function getProduct(): HasCompositionInterface;

    public function getStandartRecipe(): array
    {
        return $this->standartRecipe;
    }
}
