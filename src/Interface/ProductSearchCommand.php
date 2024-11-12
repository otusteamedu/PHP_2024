<?php

namespace VSukhov\Hw12\Interface;

use VSukhov\Hw12\Application\DTO\ProductSearchCriteria;
use VSukhov\Hw12\Application\Service\ProductSearchService;

class ProductSearchCommand
{
    private ProductSearchService $productSearchService;

    public function __construct(ProductSearchService $productSearchService)
    {
        $this->productSearchService = $productSearchService;
    }

    public function execute(array $args): void
    {
        $criteria = new ProductSearchCriteria();

        foreach ($args as $arg) {
            if (str_starts_with($arg, '--category=')) {
                $criteria->category = substr($arg, 11);
            } elseif (str_starts_with($arg, '--price-min=')) {
                $criteria->priceMin = (int)substr($arg, 12);
            } elseif (str_starts_with($arg, '--price-max=')) {
                $criteria->priceMax = (int)substr($arg, 12);
            } elseif ($arg === '--in-stock') {
                $criteria->inStock = true;
            }
        }

        $results = $this->productSearchService->searchProducts($criteria);

        foreach ($results as $product) {
            echo sprintf(
                "ID: %s, Title: %s, Category: %s, Price: %d\n",
                $product->getId(),
                $product->getTitle(),
                $product->getCategory()->getName(),
                $product->getPrice()->getAmount()
            );
        }
    }
}
