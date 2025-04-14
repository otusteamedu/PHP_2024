<?php

namespace AnatolyShilyaev\App\Application\UseCase;

use AnatolyShilyaev\App\Domain\Product\Entity\Product;
use AnatolyShilyaev\App\Domain\Product\Interfaces\IngredientDecoratorFactoryInterface;

class AddIngredientsUseCase
{
    public function __construct(
        private IngredientDecoratorFactoryInterface $decoratorFactory,
    ) {}

    public function execute(Product $product, array $ingredients): Product
    {
        foreach ($ingredients as $ingredient) {
            $product = $this->decoratorFactory->decorate($product, $ingredient);
        }

        return $product;
    }
}
