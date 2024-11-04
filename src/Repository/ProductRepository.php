<?php

namespace VSukhov\Hw12\Repository;

use Elastic\Elasticsearch\Response\Elasticsearch;
use VSukhov\Hw12\Service\IndexerService;
use VSukhov\Hw12\Service\SearchQueryBuilder;
use VSukhov\Hw12\Service\SearchService;

class ProductRepository
{
    private SearchService $esService;

    public function __construct(SearchService $esService)
    {
        $this->esService = $esService;
    }

    public function loadProductsFromFile(string $filePath): void
    {
        $indexer = new IndexerService($this->esService);
        $indexer->loadBooksFromFile($filePath);
    }

    public function searchProducts(SearchQueryBuilder $queryBuilder): Elasticsearch
    {
        return $this->esService->search('otus-shop', $queryBuilder);
    }
}
