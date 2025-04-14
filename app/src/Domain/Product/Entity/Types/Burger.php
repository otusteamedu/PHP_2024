<?php

namespace AnatolyShilyaev\App\Domain\Product\Entity\Types;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class Burger extends Product
{
    public function __construct()
    {
        parent::__construct('Burger');
        $this->addIngredient('bun', 1.0);
        $this->addIngredient('patty', 2.5);
        $this->addIngredient('meat', 3.5);
    }
}
