<?php

namespace App\Domain\Factories\Products;

use App\Domain\Entities\Products\ProductInterface;

interface ProductFactoryInterface
{
    public function make(): ProductInterface;
}