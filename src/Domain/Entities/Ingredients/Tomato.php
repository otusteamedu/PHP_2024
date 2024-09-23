<?php

namespace Ingredients;

class Tomato implements IngredientInterface
{
    public function getName(): string
    {
        return 'Tomato';
    }
}