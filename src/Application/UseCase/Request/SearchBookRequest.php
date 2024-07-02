<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class SearchBookRequest
{
    public ?string $title;
    public ?string $category;
    public ?int $minPrice;
    public ?int $maxPrice;
    public ?string $shopName;
    public ?int $minStock;

    public function __construct
    (
        ?string $title,
        ?string $category,
        ?int $minPrice,
        ?int $maxPrice,
        ?string $shopName,
        ?int $minStock
    )
    {
        $this->title = $title;
        $this->category = $category;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
        $this->shopName = $shopName;
        $this->minStock = $minStock;
    }
}
