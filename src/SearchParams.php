<?php

namespace Ahar\Hw11;

use DomainException;

class SearchParams
{
    private string $index;
    private string $query;
    private string $category;
    private string $maxPrice;
    private string $minPrice;


    public function __construct()
    {
        $options = getopt("", ["index:", "query:", "category:", "maxPrice:", "minPrice:"]);
        $index = $options['index'] ?? '';
        if (empty($index)) {
            throw new DomainException("index not set");
        }
        $this->index = $index;
        $this->query = $options['query'] ?? '';
        $this->category = $options['category'] ?? '';
        $this->maxPrice = !empty($options['maxPrice']) ? (int)$options['maxPrice'] : 0;
        $this->minPrice = !empty($options['minPrice']) ? (int)$options['minPrice'] : 0;
    }


    public function getIndex(): string
    {
        return $this->index;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getMaxPrice(): string
    {
        return $this->maxPrice;
    }

    public function getMinPrice(): string
    {
        return $this->minPrice;
    }
}
