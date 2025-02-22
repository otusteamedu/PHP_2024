<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Ingredient\AbstractIngredient;

abstract class AbstractProduct implements HasCompositionInterface
{
    protected array $composition = [];

    public function __construct(AbstractIngredient ...$basicComposition)
    {
        foreach ($basicComposition as $ingredient) {
            $this->addIngredient($ingredient);
        }
    }

    public function getComposition(): array
    {
        return $this->composition;
    }

    public function addIngredient(AbstractIngredient $ingredient): static
    {
        $ingredientName = get_class($ingredient);
        $this->composition[$ingredientName] = ($this->composition[$ingredientName] ?? 0) + 1;

        return $this;
    }
}
