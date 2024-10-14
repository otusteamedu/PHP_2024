<?php

declare(strict_types=1);

namespace App\Shared\Search;

readonly class SearchResults
{
    public function __construct(
        private array $items = []
    ) {}

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCount(): int
    {
        return count($this->getItems());
    }
}
