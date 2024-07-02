<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

class ElasticsearchBookQueryBuilder
{
    private $bodyParams;
    private $toAllBodyParams = [];

    private $indexName;
    private $title;
    private $category;
    private $minPrice;

    private $maxPrice;
    private $shopName;
    private $minStock;

    public function __construct(string $indexName)
    {
        $this->indexName = $indexName;
        $this->toAllBodyParams = [
            'query' => [
                'match_all' => new \stdClass()
            ]
        ];
    }

    public function build():self
    {
        if (isset($this->title)) {
            $this->bodyParams['query']['bool']['must'][] = ['match' => ['title' => ["query" => $this->title, "fuzziness" => "auto"]]];
        }

        if (isset($this->category)) {
            $this->bodyParams['query']['bool']['must'][] = ['match' => ['category' => $this->category]];
        }

        if (isset($this->minPrice) && isset($this->maxPrice)) {
            $this->bodyParams['query']['bool']['must'][] = ['range' => ['price' => ['gte' => $this->minPrice, 'lte' => $this->maxPrice]]];
        } elseif (isset($this->minPrice)) {
            $this->bodyParams['query']['bool']['must'][] = ['range' => ['price' => ['gte' => $this->minPrice]]];
        } elseif (isset($this->maxPrice)) {
            $this->bodyParams['query']['bool']['must'][] = ['range' => ['price' => ['lte' => $this->maxPrice]]];
        }

        if (isset($this->shopName) && isset($this->minStock)) {
            $this->bodyParams['query']['bool']['must'][] = [
                'nested' => [
                    'path' => 'stock',
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['match' => ['stock.shop' => $this->shopName]],
                                ['range' => ['stock.stock' => ['gte' => $this->minStock]]]
                            ]
                        ]
                    ]
                ]
            ];
        } elseif (isset($this->shopName)) {
            $this->bodyParams['query']['bool']['must'][] = [
                'nested' => [
                    'path' => 'stock',
                    'query' => ['match' => ['stock.shop' => $this->shopName]]
                ]
            ];
        } elseif (isset($this->minStock)) {
            $this->bodyParams['query']['bool']['must'][] = [
                'nested' => [
                    'path' => 'stock',
                    'query' => ['range' => ['stock.stock' => ['gte' => $this->minStock]]]
                ]
            ];
        }

        return $this;
    }

    public function getBodyParams() :array
    {
        return $this->bodyParams ?? $this->toAllBodyParams;
    }

    public function getQuery(): array
    {
        return [
            'index' => $this->indexName,
            'body' => $this->getBodyParams()
        ];
    }



    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }


    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }


    public function setMinPrice(?int $minPrice): self
    {
        $this->minPrice = $minPrice;
        return $this;
    }


    public function setMaxPrice(?int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }


    public function setShopName(?string $shopName): self
    {
        $this->shopName = $shopName;
        return $this;
    }


    public function setMinStock(?int $minStock): self
    {
        $this->minStock = $minStock;
        return $this;
    }

}
