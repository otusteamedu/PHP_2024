<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Ingredient\{BurgerBun, OnionDecorator, Patty, SauceDecorator};

class BurgerCook extends AbstractProductCook
{
    private readonly array $basicComposition;

    public function __construct(BurgerBun $bun, Patty $patty)
    {
        $this->basicComposition = func_get_args();
        $this->standartRecipe = [OnionDecorator::class, SauceDecorator::class];
    }

    public function getProduct(): HasCompositionInterface
    {
        return new Burger(...$this->basicComposition);
    }
}
