<?php

declare(strict_types=1);

namespace App\Domain\Product;

interface HasCompositionInterface
{
    public function getComposition(): array;
}
