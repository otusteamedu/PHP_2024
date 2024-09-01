<?php

namespace App\Domain\Values;

use DateTime;
use InvalidArgumentException;

class Date
{
    private DateTime $value;

    public function __construct(string $value)
    {
        $timestamp = strtotime($value);

        $this->assertValidValue($timestamp);

        $this->value = (new DateTime)->setTimestamp($timestamp);
    }

    public function getValue(): DateTime
    {
        return $this->value;
    }

    private function assertValidValue(int|false $timestamp): void
    {
        if ($timestamp === false) {
            throw new InvalidArgumentException('Invalid date format.');
        }
    }

    public function __toString(): string
    {
        return $this->getValue()->format('d-m-Y');
    }
}
