<?php

namespace App\Domain\Traits\Products;

use App\Domain\Entities\Ingredients\IngredientInterface;

trait HasIngredients
{
    /**
     * @var IngredientInterface[]
     */
    protected array $ingredients = [];

    public function addIngredient(IngredientInterface $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    public function addIngredients(IngredientInterface ...$ingredients): void
    {
        $this->ingredients = array_merge($this->ingredients, $ingredients);
    }

    /**
     * @return IngredientInterface[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}
