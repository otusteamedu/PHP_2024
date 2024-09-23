<?php

use Ingredients\Bun;
use Ingredients\Ketchup;
use Ingredients\Mustard;
use Ingredients\Salat;
use Ingredients\Tomato;
use Interfaces\Recipes\InteractsWithIngredients;
use Traits\Recipes\WithIngredients;

class VeggieBurgerDecorator implements RecipeDecoratorInterface, InteractsWithIngredients
{
    use WithIngredients;

    public function __construct(ProductInterface $product)
    {
        $this->addIngredients(
            new Bun(),
            new Tomato(),
            new Salat(),
            new Ketchup(),
            new Mustard()
        );
    }
}