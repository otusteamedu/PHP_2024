<?php

namespace App\Domain\DTO\SelectQueryBuilder;

class WhereDTO
{
    public function __construct(
        public readonly string $attribute,
        public readonly string $value,
        public readonly ?string $operator,
    ) {
    }
}
