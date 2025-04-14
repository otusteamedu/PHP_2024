<?php

namespace AnatolyShilyaev\App\Domain\Product\Services\Chain;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Entity\Types\HotDog;

class HotDogHandler extends AbstractProductHandler
{
    public function handle(string $type): ?Product
    {
        if (strtolower($type) === 'hotdog') {
            return new HotDog();
        }

        return parent::handle($type);
    }
}
