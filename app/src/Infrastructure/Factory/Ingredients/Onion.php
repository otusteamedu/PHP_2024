<?php

namespace AnatolyShilyaev\App\Infrastructure\Factory\Ingredients;

class Onion extends BaseIngredientDecorator
{
    public function getIngredients(): array
    {
        return array_merge($this->product->getIngredients(), ['onion']);
    }
}
