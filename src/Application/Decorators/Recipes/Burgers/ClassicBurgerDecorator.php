<?php

use Ingredients\Bun;
use Ingredients\Ketchup;
use Ingredients\Meat;
use Interfaces\Recipes\InteractsWithIngredients;
use Traits\Recipes\WithIngredients;

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