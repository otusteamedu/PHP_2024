<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Ingredient\{Bread, CheeseDecorator};

class SandwichCook extends AbstractProductCook
{
    private readonly array $basicComposition;

    public function __construct(Bread $bread)
    {
        $this->basicComposition = func_get_args();
        $this->standartRecipe = [CheeseDecorator::class];
    }

    public function getProduct(): HasCompositionInterface
    {
        return new Sandwich(...$this->basicComposition);
    }
}
