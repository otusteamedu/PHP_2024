<?php

namespace VSukhov\Hw12\Infostructure\Elastic;

use VSukhov\Hw12\Application\DTO\ProductSearchCriteria;
use VSukhov\Hw12\Domain\Entity\Product;
use VSukhov\Hw12\Domain\Repository\ProductRepositoryInterface;
use VSukhov\Hw12\Domain\ValueObject\Category;
use VSukhov\Hw12\Domain\ValueObject\Price;
use VSukhov\Hw12\Domain\ValueObject\Stock;

class ProductRepository implements ProductRepositoryInterface
{
    private ElasticSearchService $elasticSearchService;

    public function __construct(ElasticSearchService $elasticSearchService)
    {
        $this->elasticSearchService = $elasticSearchService;
    }

    public function search(ProductSearchCriteria $criteria): array
    {
        $query = ['bool' => ['must' => []]];

        if ($criteria->category) {
            $query['bool']['must'][] = ['match' => ['category' => $criteria->category]];
        }

        if ($criteria->priceMin !== null || $criteria->priceMax !== null) {
            $range = [];
            if ($criteria->priceMin !== null) {
                $range['gte'] = $criteria->priceMin;
            }
            if ($criteria->priceMax !== null) {
                $range['lte'] = $criteria->priceMax;
            }
            $query['bool']['must'][] = ['range' => ['price' => $range]];
        }

        if ($criteria->inStock) {
            $query['bool']['must'][] = ['range' => ['stock.stock' => ['gt' => 0]]];
        }

        $results = $this->elasticSearchService->search('otus-shop', ['query' => $query]);

        return array_map(function ($hit) {
            return new Product(
                $hit['_id'],
                $hit['_source']['title'],
                new Category($hit['_source']['category']),
                new Price((int)$hit['_source']['price']),
                new Stock((int)($hit['_source']['stock'][0]['stock'] ?? 0))
            );
        }, $results['hits']['hits']);
    }
}
