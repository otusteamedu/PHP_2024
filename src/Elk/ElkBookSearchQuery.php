<?php

declare(strict_types=1);

namespace Alogachev\Homework\Elk;

readonly class ElkBookSearchQuery
{
    public function __construct(
        private string $indexName,
        private ?string $title = null,
        private ?string $category = null,
        private ?int $lessThanPrice = null,
        private ?int $graterThanPrice = null,
        private ?string $shopName = null,
    ) {
    }

    public function getIndexName(): string
    {
        return $this->indexName;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getLessThanPrice(): ?int
    {
        return $this->lessThanPrice;
    }

    public function getGraterThanPrice(): ?int
    {
        return $this->graterThanPrice;
    }

    public function getShopName(): ?string
    {
        return $this->shopName;
    }
}
