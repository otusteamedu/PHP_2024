<?php

namespace App\Domain\Entities\Ingredients;

class Tomato implements IngredientInterface
{
    public function getName(): string
    {
        return 'Tomato';
    }
}
