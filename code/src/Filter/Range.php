<?php

declare(strict_types=1);

namespace IraYu\Hw11\Filter;

class Range extends Filter
{
    protected mixed $min;
    protected mixed $max;

    public function setMin(mixed $min): static
    {
        $this->min = $min;

        return $this;
    }

    public function setMax(mixed $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function getFilter(): array
    {
        return [
            'range' => [
                $this->field => [] + (isset($this->min) ? [
                    'gte' => $this->min
                ] : []) + (isset($this->max) ? [
                    'lte' => $this->max
                ] : [])
            ]
        ];
    }
}
