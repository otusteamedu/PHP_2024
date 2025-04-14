<?php

namespace AnatolyShilyaev\App\Domain\Product\Services\Chain;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Entity\Types\Sandwich;

class SandwichHandler extends AbstractProductHandler
{
    public function handle(string $type): ?Product
    {
        if (strtolower($type) === 'sandwich') {
            return new Sandwich();
        }

        return parent::handle($type);
    }
}
