<?php

namespace App\Domain\Entities\Ingredients;

class Bun implements IngredientInterface
{
    public function getName(): string
    {
        return 'Bun';
    }
}
