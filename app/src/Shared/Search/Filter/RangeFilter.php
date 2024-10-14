<?php

declare(strict_types=1);

namespace App\Shared\Search\Filter;

readonly class RangeFilter implements FilterInterface
{
    public function __construct(
        private string $field,
        private FilterInterface $from,
        private ?FilterInterface $to = null,
    ) {}

    public function getField(): string
    {
        return $this->field;
    }

    public function getCondition(): array
    {
        $range[$this->from->getCondition()] = $this->from->getValue();

        if (null !== $this->to) {
            $range[$this->to->getCondition()] = $this->to->getValue();
        }

        return $range;
    }

    public function getValue(): string
    {
        return '';
    }
}