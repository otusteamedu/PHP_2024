<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Domain\ValueObject;

use InvalidArgumentException;

class Rating
{
    private int $value;

    public function __construct(int $value)
    {
        $this->assertValidRating($value);
        $this->value = $value;
    }

    private function assertValidRating(int $value): void
    {
        if ($this->value < 1 || $this->value > 5) {
            throw new InvalidArgumentException('Rating value must be between 1 and 5');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
