<?php

namespace App\Domain\RepositoryInterface;

use App\Domain\Entity\Purchase;

interface PurchaseRepositoryInterface
{
    public function create(Purchase $purchase): int;
}
