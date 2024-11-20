<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Dto;

class SearchDto
{
    public string $query;
    public ?string $category = null;
    public ?int $minPrice = null;
    public ?int $maxPrice = null;
    public int $quantity = 0;

    public static function createFromSearchData(array $searchData): self
    {
        $dto = new self();
        $dto->query = $searchData['query'];
        $dto->category = '' === $searchData['category'] ? null : $searchData['category'];
        $dto->minPrice = '' === $searchData['minPrice'] ? null : (int) $searchData['minPrice'];
        $dto->maxPrice = '' === $searchData['maxPrice'] ? null : (int) $searchData['maxPrice'];
        $dto->quantity = '' === $searchData['quantity'] ? 0 : (int) $searchData['quantity'];

        return $dto;
    }
}
