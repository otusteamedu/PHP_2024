<?php

use Interfaces\Products\WithIngredients;
use Traits\Products\HasIngredients;

class Burger implements ProductInterface, WithIngredients
{
    use HasIngredients;

    public function getName(): string
    {
        return 'Burger';
    }
}