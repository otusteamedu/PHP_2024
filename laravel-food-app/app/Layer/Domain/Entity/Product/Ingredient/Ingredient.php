<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product\Ingredient;

use App\Layer\Domain\Entity\EntityInterface\CompositeItemInterface;

class Ingredient implements CompositeItemInterface
{
    private string $name;
    public $price;

    public function setName(string $name): string
    {
        $this->name = $name;
        return $this->name;
    }
    public function calcPrice($price = null)
    {
        $this->price = $price + 3; // + 3 - условная наценка на ингрд.
        return $this->price;
    }
}
