<?php

declare(strict_types=1);

namespace App\Domain\Dto;

use App\Domain\Enum\ValueMatchingType;

readonly class SearchCondition
{
    public function __construct(
        public string $field,
        public string $value,
        public ValueMatchingType $comparisonType
    ) {
    }
}
