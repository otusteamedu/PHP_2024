<?php

declare(strict_types=1);

namespace Domain\Builders;

use Domain\Decorators\BasicProduct;
use Domain\Decorators\ProductDecorator;
use Domain\Decorators\ProductInterface;
use Domain\Strategies\ProductStrategyInterface;

class ProductBuilder
{
    private ProductInterface $product;
    private array $ingredients = [];

    public function __construct(ProductStrategyInterface $strategy)
    {
        $this->product = new BasicProduct($strategy->createProduct());
    }

    public function addIngredient(string $decoratorClass): static
    {
        $this->ingredients[] = $decoratorClass;

        return $this;
    }

    public function build(): ProductDecorator
    {
        foreach ($this->ingredients as $decorator) {
            $this->product = new $decorator($this->product);
        }

        return $this->product;
    }
}
