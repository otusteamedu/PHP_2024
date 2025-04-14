<?php

namespace AnatolyShilyaev\App\Domain\Product\Interfaces;

use AnatolyShilyaev\App\Domain\Product\Entities\Product;

interface ProductBuilderStrategyInterface
{
    public function build(): Product;
}
