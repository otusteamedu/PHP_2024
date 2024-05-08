<?php

namespace AKornienko\Php2024\Domain;

class Priority
{
    private int $value;

    public function __construct(mixed $value)
    {
        $this->assertPriorityIsValid($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return strval($this->value);
    }

    private function assertPriorityIsValid(mixed $value)
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException(
                "Приоритет должен быть числом"
            );
        }
    }
}
