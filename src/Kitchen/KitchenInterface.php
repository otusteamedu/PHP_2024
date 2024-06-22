<?php

declare(strict_types=1);

namespace App\Kitchen;

use App\Food\Product;

interface KitchenInterface
{
    public function makeBurger(): Product;
    public function makeSandwich(): Product;
    public function makeHotDog(): Product;
}
