<?php

declare(strict_types=1);

namespace IraYu\Hw11\Filter;

class MatchFilter extends Filter
{
    public function __construct(
        protected string $field,
        protected mixed $value,
    ) {
        parent::__construct($field);
    }

    public function getFilter(): ?array
    {
        return [
            'match' => [
                $this->field => [
                    'query' => $this->value,
                    'fuzziness' => 'auto'
                ]
            ]
        ];
    }
}
