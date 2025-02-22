<?php

declare(strict_types=1);

namespace App\Domain\Product;

interface CanCookProductInterface
{
    public function getProduct(): HasCompositionInterface;
}
