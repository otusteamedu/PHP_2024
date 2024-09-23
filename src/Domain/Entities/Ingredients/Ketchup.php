<?php

namespace App\Domain\Entities\Ingredients;

class Ketchup implements IngredientInterface
{
    public function getName(): string
    {
        return 'Ketchup';
    }
}