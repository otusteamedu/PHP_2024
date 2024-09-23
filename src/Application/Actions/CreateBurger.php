<?php

class CreateBurger
{
    public function __invoke(BurgerFactory $factory, BurgerType $type): Burger
    {
        $burger = $factory->make();
        $recipe = $type->getRecipe();

        return new $recipe($burger);
    }
}