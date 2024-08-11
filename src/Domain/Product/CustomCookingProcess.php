<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Product\HasCompositionInterface;

class CustomCookingProcess extends AbstractCookingProcess
{
    public function applyRecipe(AbstractProduct $product, string ...$productCustomizers): HasCompositionInterface
    {
        return array_reduce(
            $this->productCustomizers,
            fn(AbstractProduct $product, string $productCustomizer) => $this->makeCustomizer($productCustomizer, $product)->getProduct(),
            $product
        );
    }
}
