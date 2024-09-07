<?php

declare(strict_types=1);

namespace IraYu\Hw11\Filter;

class Equality extends Filter
{
    public function __construct(
        protected string $field,
        protected mixed $value,
    ) {
        parent::__construct($field);
    }

    public function getFilter(): array
    {
        return [
            'term' => [
                $this->field => $this->value
            ]
        ];
    }
}
