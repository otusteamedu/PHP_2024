<?php

declare(strict_types=1);

namespace App\Application\DTO;

class OrderDto
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $cook = null,
        public readonly ?string $cookingProcess = null,
        public readonly ?array $productCustomizers = null
    ) {}
}
