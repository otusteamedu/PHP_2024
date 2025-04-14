<?php

namespace AnatolyShilyaev\App\Infrastructure\Factory\Ingredients;

class Lettuce extends BaseIngredientDecorator
{
    public function getIngredients(): array
    {
        return array_merge($this->product->getIngredients(), ['lettuce']);
    }
}
