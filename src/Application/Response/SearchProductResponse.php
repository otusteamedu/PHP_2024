<?php

declare(strict_types=1);

namespace App\Application\Response;

readonly class SearchProductResponse
{
    public function __construct(
        public string $id,
        public string $title,
        public string $category,
        public int $price,
        public int $stock
    ) {
    }
}
