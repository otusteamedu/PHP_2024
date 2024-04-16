<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Index;

class SearchResult
{
    public function __construct(
        private readonly int $totalCount,
        private readonly array $hits
    )
    {
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getHits(): array
    {
        return $this->hits;
    }
}
