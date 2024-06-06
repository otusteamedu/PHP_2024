<?php

declare(strict_types=1);

namespace JuliaZhigareva\ElasticProject;

use DomainException;

final class Arguments
{
    public string $index = "index:";
    public string $searchQuery = "searchQuery:";
    public ?string $category = "category:";
    public ?string $maxPrice = "maxPrice:";
    public ?string $minPrice = "minPrice:";

    public function __construct()
    {
        getopt("", [$this->index, $this->searchQuery, $this->category, $this->maxPrice, $this->minPrice]);
        if (empty($this->index)) {
            throw new DomainException("index не был передан");
        }
    }
}
