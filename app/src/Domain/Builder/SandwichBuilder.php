<?php

namespace Otus\Hw16\Domain\Builder;

use Otus\Hw16\Domain\Entity\FoodItem;

class SandwichBuilder implements FoodItemBuilderInterface
{
    private FoodItem $foodItem;

    public function __construct()
    {
        $this->foodItem = new FoodItem('sandwich');
    }

    public function setBase(): self
    {
        $this->foodItem = $this->foodItem->withIngredient('bread')->withIngredient('ham');
        return $this;
    }

    public function getProduct(): FoodItem
    {
        return $this->foodItem;
    }
}
