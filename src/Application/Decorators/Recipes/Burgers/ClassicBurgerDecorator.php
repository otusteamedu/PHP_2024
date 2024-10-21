<?php

namespace App\Application\Decorators\Recipes\Burgers;

use App\Domain\Decorators\Recipes\InteractsWithIngredients;
use App\Domain\Decorators\Recipes\RecipeDecoratorInterface;
use App\Domain\Entities\Ingredients\Bun;
use App\Domain\Entities\Ingredients\Ketchup;
use App\Domain\Entities\Ingredients\Meat;
use App\Domain\Entities\Products\ProductInterface;
use App\Domain\Traits\Products\WithIngredients;

class ClassicBurgerDecorator implements RecipeDecoratorInterface, InteractsWithIngredients
{
    use WithIngredients;

    public function __construct(ProductInterface $product)
    {
        $this->addIngredients(
            new Bun(),
            new Meat(),
            new Ketchup()
        );
    }
}
