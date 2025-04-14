<?php

namespace AnatolyShilyaev\App\Domain\Product\Interfaces;

use AnatolyShilyaev\App\Domain\Product\Entities\Product;

abstract class CookTemplateInterface
{
    final public function cook(Product $product): void
    {
        $this->preCook($product);
        $this->cookLogic($product);
        $this->postCook($product);
    }

    protected abstract function preCook(Product $product): void;
    protected abstract function cookLogic(Product $product): void;
    protected abstract function postCook(Product $product): void;
}
