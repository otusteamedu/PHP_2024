<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Builder;

use Otus\Hw16\Domain\Entity\FoodItem;

class HotDogBuilder implements FoodItemBuilderInterface
{
    private FoodItem $foodItem;

    public function __construct()
    {
        $this->foodItem = new FoodItem('hotdog');
    }

    public function setBase(): self
    {
        $this->foodItem = $this->foodItem->withIngredient('bun')->withIngredient('sausage');
        return $this;
    }

    public function getProduct(): FoodItem
    {
        return $this->foodItem;
    }
}
