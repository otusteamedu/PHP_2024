<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Condition
{
    public function __construct(private readonly string $paramName, private readonly string $paramValue)
    {
    }

    public function getParamName(): string
    {
        return $this->paramName;
    }
    public function getParamValue(): string
    {
        return $this->paramValue;
    }
    public function getValue(): array
    {
        return [$this->paramName => $this->paramValue];
    }
    public function __toString(): string
    {
        return $this->paramName . ' = ' . $this->paramValue;
    }
}
