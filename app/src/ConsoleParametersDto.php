<?php

declare(strict_types=1);

namespace Dsergei\Hw11;
class ConsoleParametersDto
{
    public function __construct(
        private string $index,
        private string $search,
        private float $minPrice,
        private float $maxPrice,
        private string $category
    ) {

    }

    public function getIndex(): string
    {
        return $this->index;
    }

    public function getSearch(): string|null
    {
        return $this->search;
    }

    public function getMinPrice(): float|null
    {
        return $this->minPrice;
    }

    public function getMaxPrice(): float|null
    {
        return $this->maxPrice;
    }

    public function getCategory(): string|null
    {
        return $this->category;
    }
}