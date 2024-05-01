<?php

declare(strict_types=1);

namespace AShutov\Hw15;

readonly class Conditions
{
    public array $conditions;

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    public function toString(): string
    {
        $value = '';

        foreach ($this->conditions as $key => $val) {
            $value .= "$key:$val;";
        }

        return $value;
    }
}
