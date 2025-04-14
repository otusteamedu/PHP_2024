<?php

namespace AnatolyShilyaev\App\Domain\Product\Interfaces;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;

interface ProductObserverInterface
{
    public function update(Product $product): void;
}
