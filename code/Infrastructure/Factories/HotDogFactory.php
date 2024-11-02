<?php

declare(strict_types=1);

namespace Infrastructure\Factories;

use Domain\Entities\HotDog;
use Domain\Entities\Product;
use Domain\Factories\ProductFactoryInterface;

class HotDogFactory implements ProductFactoryInterface
{
    public function createProduct(): Product
    {
        return new HotDog();
    }
}
