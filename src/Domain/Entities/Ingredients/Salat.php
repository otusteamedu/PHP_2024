<?php

namespace App\Domain\Entities\Ingredients;

class Salat implements IngredientInterface
{
    public function getName(): string
    {
        return 'Salat';
    }
}