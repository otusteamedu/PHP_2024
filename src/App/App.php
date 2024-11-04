<?php

namespace VSukhov\Hw12\App;

use VSukhov\Hw12\Repository\ProductRepository;
use VSukhov\Hw12\Service\SearchQueryBuilder;
use VSukhov\Hw12\Service\SearchService;

class App
{
    public function run(): array
    {
        $esService = new SearchService();
        $productRepository = new ProductRepository($esService);

        $productRepository->loadProductsFromFile(__DIR__ . '/../books.json');

        $queryBuilder = (new SearchQueryBuilder())
            ->byCategory('Фантастика')
            ->byPriceRange(1000, 5000)
            ->inStock();

        return $productRepository->searchProducts($queryBuilder)->asArray();
    }
}
