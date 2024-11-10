<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Order;

interface ProductRepositoryInterface
{
    public function getProducts(Order $order): array;
}
