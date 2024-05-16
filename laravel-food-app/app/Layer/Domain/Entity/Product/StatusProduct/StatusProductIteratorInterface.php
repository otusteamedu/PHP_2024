<?php

declare(strict_types=1);

namespace App\Layer\Domain\Entity\Product\StatusProduct;

interface StatusProductIteratorInterface
{
    public function nextStatus();
    public function hasNextStatus();
}
