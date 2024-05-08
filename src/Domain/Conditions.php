<?php

namespace AKornienko\Php2024\Domain;

readonly class Conditions
{
    private array $conditions;

    public function __construct(array $conditions)
    {
        $this->assertConditionsIsValid($conditions);
        $rawConditions = $conditions;
        ksort($rawConditions);
        $this->conditions = $rawConditions;
    }

    public function getValue(): array
    {
        return $this->conditions;
    }

    public function toString(): string
    {
        $value = '';

        foreach ($this->conditions as $key => $value) {
            $value .= "$key:$value;";
        }
        return $value;
    }

    private function assertConditionsIsValid(array $value)
    {
        if (count($value) === 0) {
            throw new \InvalidArgumentException(
                "Задайте правильные кондиции для события"
            );
        }
    }
}
