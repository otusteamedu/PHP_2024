<?php

namespace App\Domain\Entities\Ingredients;

class Mustard implements IngredientInterface
{
    public function getName(): string
    {
        return 'Mustard';
    }
}
