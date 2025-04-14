<?php

namespace AnatolyShilyaev\App\Domain\Product\Services\Chain;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Entity\Types\Burger;

class BurgerHandler extends AbstractProductHandler
{
    public function handle(string $type): ?Product
    {
        if (strtolower($type) === 'burger') {
            return new Burger();
        }

        return parent::handle($type);
    }
}
