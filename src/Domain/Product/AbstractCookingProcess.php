<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Ingredient\AbstractDecorator;
use App\Domain\Product\{AbstractProductCook, HasCompositionInterface};

abstract class AbstractCookingProcess
{
    protected AbstractProductCook $cook;
    protected array $productCustomizers;

    abstract protected function applyRecipe(AbstractProduct $product): HasCompositionInterface;

    public function cook(AbstractProductCook $cook, ?string ...$productCustomizers): HasCompositionInterface
    {
        $this->cook = $cook;
        $this->productCustomizers = $productCustomizers;

        $product = $cook->getProduct();

        return $this->applyRecipe($product);
    }

    protected function makeCustomizer(string $productCustomizer, AbstractProduct $product): AbstractDecorator
    {
        return new $productCustomizer($product);
    }
}
