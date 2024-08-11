<?php

declare(strict_types=1);

namespace App\Application\Product;

use App\Domain\Product\{AbstractCookingProcess, AbstractProductCook};

class CookProductAction
{
    public function cook(AbstractProductCook $cook, AbstractCookingProcess $cookingProcess, ?string ...$productCustomizers): void
    {
        $product = $cookingProcess->cook($cook, ...$productCustomizers);
    }
}
