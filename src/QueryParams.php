<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

readonly class QueryParams
{
    public function __construct(
        public string $searchQuery,
        public string $category,
        public int $maxPrice,
        public int $minPrice
    ) {
    }

}