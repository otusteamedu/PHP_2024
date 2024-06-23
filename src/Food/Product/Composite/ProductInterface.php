<?php

declare(strict_types=1);

namespace App\Food\Product\Composite;

use App\Food\FoodComponentInterface;

interface ProductInterface extends FoodComponentInterface
{
    public function addIngredient(FoodComponentInterface $ingredient): void;
    /** @return FoodComponentInterface[] */
    public function getIngredients(): array;
}
