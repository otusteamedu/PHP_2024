<?php

declare(strict_types=1);

namespace Domain\Factories;

use Domain\Entities\Product;

interface ProductFactoryInterface
{
    public function createProduct(): Product;
}
