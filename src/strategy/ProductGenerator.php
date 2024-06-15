<?php

declare(strict_types=1);

namespace Afilipov\Hw16\strategy;

class ProductGenerator
{
    public function __invoke(IProduct $strategy): string
    {
        return $strategy->generateProduct();
    }
}
