<?php

namespace App\Application\Actions\Products;

use App\Application\Enums\Recipes\BurgerType;
use App\Application\Factories\Products\BurgerFactory;
use App\Domain\Entities\Products\Burger;

class CreateBurger
{
    public function __invoke(BurgerFactory $factory, BurgerType $type): Burger
    {
        $burger = $factory->make();
        $recipe = $type->getRecipe();

        return new $recipe($burger);
    }
}
