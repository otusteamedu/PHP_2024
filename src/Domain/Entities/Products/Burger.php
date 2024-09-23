<?php

namespace App\Domain\Entities\Products;

use App\Domain\Traits\Products\HasIngredients;

class Burger implements ProductInterface, WithIngredients
{
    use HasIngredients;

    public function getName(): string
    {
        return 'Burger';
    }
}