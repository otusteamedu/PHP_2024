<?php

namespace AKornienko\Php2024\models;

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
