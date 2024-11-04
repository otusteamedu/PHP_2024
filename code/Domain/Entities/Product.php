<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\ValueObjects\Ingredient;

abstract class Product
{
    protected array $ingredients = [];

    public function addIngredient(Ingredient $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    abstract public function getDescription(): string;
}
