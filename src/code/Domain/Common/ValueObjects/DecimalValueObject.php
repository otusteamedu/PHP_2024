<?php

declare(strict_types=1);

namespace Domain\Common\ValueObjects;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

abstract class DecimalValueObject
{
    protected BigDecimal $value;

    public function __construct(string $value)
    {
        $this->value = BigDecimal::of($value);
    }

    public function getValue(): BigDecimal
    {
        return $this->value;
    }

    public function equals(DecimalValueObject $other): bool
    {
        return $this->value->compareTo($other->value) === 0;
    }

    public function add(DecimalValueObject $other): self
    {
        return new static((string)$this->value->plus($other->value)->toScale(2, RoundingMode::HALF_UP));
    }

    public function subtract(DecimalValueObject $other): self
    {
        return new static((string)$this->value->minus($other->value)->toScale(2, RoundingMode::HALF_UP));
    }

    public function multiply(DecimalValueObject $other): self
    {
        return new static((string)$this->value->multipliedBy($other->value)->toScale(2, RoundingMode::HALF_UP));
    }

    public function divide(DecimalValueObject $other): self
    {
        return new static((string)$this->value->dividedBy($other->value, 2, RoundingMode::HALF_UP));
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
