<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

use DomainException;

readonly class Arguments
{
    public string $index;
    public string $searchQuery;
    public string $category;
    public int $maxPrice;
    public int $minPrice;

    public function __construct()
    {
        $options = getopt("", ["index:", "searchQuery:", "category:", "maxPrice:", "minPrice:"]);
        $index = $options['index'] ?? '';
        if (empty($index)) {
            throw new DomainException("index не был передан");
        }
        $this->index = $index;
        $this->searchQuery = $options['searchQuery'] ?? '';
        $this->category = $options['category'] ?? '';
        $this->maxPrice = isset($options['maxPrice']) ? (int)$options['maxPrice'] : 0;
        $this->minPrice = isset($options['minPrice']) ? (int)$options['minPrice'] : 0;
    }
}