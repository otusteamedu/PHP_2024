<?php

declare(strict_types=1);

namespace App\Elasticsearch\Search;

use App\Search\Data;

class QueryBuilder
{
    private array $query = [
        'query' => [
            'bool' => [
                'must' => []
            ]
        ]
    ];

    public function build(): array
    {
        return $this->query;
    }

    public function all(): array
    {
        return [
            'query' => [
                'match_all' => []
            ]
        ];
    }

    public function fromData(Data $data): array
    {
        $data->title && $this->addTitle($data->title);
        $data->sku && $this->addSku($data->sku);
        $data->category && $this->addCategory($data->category);
        $data->priceMin && $this->addPriceRange($data->priceMin, 'gte');
        $data->priceMax && $this->addPriceRange($data->priceMax, 'lte');
        $data->inStock !== null && $this->addInStock($data->inStock);

        return $this->build();
    }

    public function addTitle(string $title): self
    {
        $this->query['query']['bool']['must'][] = [
            'match' => [
                'title' => [
                    'query' => $title,
                    'fuzziness' => 'AUTO',
                ]
            ]
        ];

        return $this;
    }

    public function addSku(string $sku): self
    {
        $this->query['query']['bool']['must'][] = [
            'term' => [
                'sku.keyword' => $sku
            ]
        ];

        return $this;
    }

    public function addCategory(string $category): self
    {
        $this->query['query']['bool']['must'][] = [
            'term' => [
                'category.keyword' => $category
            ]
        ];

        return $this;
    }

    public function addPriceRange(int $price, string $cond): self
    {
        $this->query['query']['bool']['must'][] = [
            'range' => [
                'price' => [$cond => $price]
            ]
        ];

        return $this;
    }

    public function addInStock(bool $inStock): self
    {
        $this->query['query']['bool']['must'][] = [
            'range' => [
                'stock.stock' => [
                    $inStock ? 'gt' : 'gte' => 0
                ]
            ]
        ];

        return $this;
    }
}