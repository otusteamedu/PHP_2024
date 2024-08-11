<?php

declare(strict_types=1);

namespace App\Application\DTO;

class OrderDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $cook,
        public readonly ?string $cookingProcess,
        public readonly ?array $productCustomizers
    ) {}
}
