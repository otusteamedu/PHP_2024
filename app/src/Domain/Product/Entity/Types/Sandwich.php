<?php

namespace AnatolyShilyaev\App\Domain\Product\Entity\Types;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class Sandwich extends Product
{
    public function __construct()
    {
        parent::__construct('Sandwich');
        $this->addIngredient('bread', 0.8);
        $this->addIngredient('cheese', 1.2);
    }
}
