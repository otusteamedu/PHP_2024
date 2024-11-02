<?php

declare(strict_types=1);

namespace Domain\Entities;

use Domain\ValueObjects\Ingredient;

class Pizza
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

    public function getPizzaDescription(): string
    {
        return "Pizza with " . implode(", ", array_map(fn($i) => $i->getName(), $this->ingredients));
    }
}
