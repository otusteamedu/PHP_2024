<?php

declare(strict_types=1);

namespace AShutov\Hw15\Models;

readonly class Conditions
{
    public array $conditions;

    public function __construct(array $conditions)
    {
        $rawConditions = $conditions;
        ksort($rawConditions);
        $this->conditions = $rawConditions;
    }

    public function toString(): string
    {
        $value = '';

        foreach ($this->conditions as $key => $value) {
            $value .= "$key:$value;";
        }

        return $value;
    }
}
