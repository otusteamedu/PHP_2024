<?php

namespace VSukhov\Hw12\Application\DTO;

class ProductSearchCriteria
{
    public ?string $category = null;
    public ?int $priceMin = null;
    public ?int $priceMax = null;
    public bool $inStock = false;
}