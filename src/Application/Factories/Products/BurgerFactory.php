<?php

namespace App\Application\Factories\Products;

use App\Domain\Factories\Products\ProductFactoryInterface;
use App\Domain\Entities\Products\ProductInterface;
use App\Domain\Entities\Products\Burger;

class BurgerFactory implements ProductFactoryInterface
{
    public function make(): ProductInterface
    {
        return new Burger();
    }
}