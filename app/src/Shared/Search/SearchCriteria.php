<?php

declare(strict_types=1);

namespace App\Shared\Search;

use App\Shared\Search\Filter\FilterInterface;

readonly class SearchCriteria
{
    public function __construct(
        private array $filters = []
    ) {}

    /**
     * @return FilterInterface[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
