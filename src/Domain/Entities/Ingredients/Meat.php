<?php

namespace Ingredients;

class Meat implements IngredientInterface
{
    public function getName(): string
    {
        return 'Meat';
    }
}