<?php

namespace Ahar\Hw11;

class QueryBuilder
{
    private array $query = [];

    public function __construct()
    {
        $this->query = [
            'query' => [
                'bool' => [
                    'must' => []
                ]
            ]
        ];
    }

    public function setQuery(string $query): static
    {
        if (empty($query)) {
            return $this;
        }

        $this->query['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $query,
                        'fuzziness' => 'AUTO',
                    ]
                ]
        ];
        return $this;
    }

    public function setCategory(string $category): static
    {
        if(empty($category)) {
            return $this;
        }

        $this->query['query']['bool']['filter'][] = [
            'term' => [
                'category.keyword' => $category
            ]
        ];
        return $this;
    }

    public function setMaxPrice(int $price): static
    {
        if(empty($price)) {
            return $this;
        }

        $this->query['query']['bool']['filter'][] = [
            'range' => [
                'price' => [
                    'lt' => $price
                ]
            ]
        ];
        return $this;
    }

    public function setMinPrice(int $price): static
    {
        if(empty($price)) {
            return $this;
        }

        $this->query['query']['bool']['filter'][] = [
            'range' => [
                'price' => [
                    'gt' => $price
                ]
            ]
        ];
        return $this;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
