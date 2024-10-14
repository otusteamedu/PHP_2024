<?php

declare(strict_types=1);

namespace App\Shared\Search\Filter;

readonly class SimpleFilter implements FilterInterface
{
    public function __construct(
        private string $field,
        private string $condition,
        private string $value,
    ) {}

    public function getField(): string
    {
        return $this->field;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}