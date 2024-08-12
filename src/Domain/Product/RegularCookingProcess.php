<?php

declare(strict_types=1);

namespace App\Domain\Product;

class RegularCookingProcess extends AbstractCookingProcess
{
    public function applyRecipe(AbstractProduct $product): HasCompositionInterface
    {
        return array_reduce(
            $this->cook->getStandartRecipe(),
            fn(AbstractProduct $product, string $productCustomizer) => $this->makeCustomizer($productCustomizer, $product)->getProduct(),
            $product
        );
    }
}
