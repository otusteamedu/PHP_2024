<?php

namespace Ingredients;

class Salami implements IngredientInterface
{
    public function getName(): string
    {
        return 'Salami';
    }
}