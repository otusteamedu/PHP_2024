<?php

namespace Otus\Hw16\Domain\Builder;

use Otus\Hw16\Domain\Entity\FoodItem;

class BurgerBuilder implements FoodItemBuilderInterface
{
    private FoodItem $foodItem;

    public function __construct()
    {
        $this->foodItem = new FoodItem('burger');
    }

    public function setBase(): self
    {
        $this->foodItem = $this->foodItem->withIngredient('bun')->withIngredient('patty');
        return $this;
    }

    public function getProduct(): FoodItem
    {
        return $this->foodItem;
    }
}
