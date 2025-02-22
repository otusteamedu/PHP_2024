<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Ingredient\{HotDogBun, SauceDecorator, Sausage};

class HotDogCook extends AbstractProductCook
{
    private readonly array $basicComposition;

    public function __construct(HotDogBun $bun, Sausage $sausage)
    {
        $this->basicComposition = func_get_args();
        $this->standartRecipe = [SauceDecorator::class];
    }

    public function getProduct(): HasCompositionInterface
    {
        return new HotDog(...$this->basicComposition);
    }
}
