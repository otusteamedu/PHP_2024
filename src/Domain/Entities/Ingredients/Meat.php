<?php

namespace App\Domain\Entities\Ingredients;

class Meat implements IngredientInterface
{
    public function getName(): string
    {
        return 'Meat';
    }
}