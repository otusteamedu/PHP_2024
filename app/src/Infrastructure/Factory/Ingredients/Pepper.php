<?php

namespace AnatolyShilyaev\App\Infrastructure\Factory\Ingredients;

class Pepper extends BaseIngredientDecorator
{
    public function getIngredients(): array
    {
        return array_merge($this->product->getIngredients(), ['pepper']);
    }
}
