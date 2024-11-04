<?php

namespace VSukhov\Hw12\Service;

class SearchQueryBuilder
{
    private array $query = [
        'bool' => [
            'must' => [],
        ],
    ];

    public function byCategory(string $category): self
    {
        $this->query['bool']['must'][] = ['match' => ['category' => $category]];
        return $this;
    }

    public function byTitle(string $title): self
    {
        $this->query['bool']['must'][] = ['match' => ['title' => $title]];
        return $this;
    }

    public function byPriceRange(?int $min, ?int $max): self
    {
        $range = [];
        if ($min !== null) {
            $range['gte'] = $min;
        }
        if ($max !== null) {
            $range['lte'] = $max;
        }
        if (!empty($range)) {
            $this->query['bool']['must'][] = ['range' => ['price' => $range]];
        }
        return $this;
    }

    public function inStock(): self
    {
        $this->query['bool']['must'][] = ['range' => ['stock' => ['gt' => 0]]];
        return $this;
    }

    public function getQuery(): array
    {
        return ['query' => $this->query];
    }
}
