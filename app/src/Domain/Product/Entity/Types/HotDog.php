<?php

namespace AnatolyShilyaev\App\Domain\Product\Entity\Types;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

class HotDog extends Product
{
    public function __construct()
    {
        parent::__construct('HotDog');
        $this->addIngredient('bun', 1.0);
        $this->addIngredient('sausage', 1.5);
    }
}
