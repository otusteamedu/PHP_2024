<?php

namespace App\Domain\Entities\Ingredients;

class Salami implements IngredientInterface
{
    public function getName(): string
    {
        return 'Salami';
    }
}