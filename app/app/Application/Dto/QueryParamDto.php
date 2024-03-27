<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application\Dto;

final readonly class QueryParamDto
{
    public function __construct(
        private string $attribute,
        private string $value,
        private string $operator
    ) {
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function getOperator(): ?string
    {
        if ($this->operator === '>') {
            return 'gt';
        }
        if ($this->operator === '<') {
            return 'lt';
        }
        return null;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getOperation(): string
    {
        return $this->getOperator() === null ? 'term' : 'range';
    }
}
