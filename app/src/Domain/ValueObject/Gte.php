<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

/**
 * Gte value object.
 */
class Gte
{
    /**
     * Value.
     */
    private int $value;

    /**
     * Construct.
     */
    public function __construct(int $value) {
        $this->assertGteIsValid($value);
        $this->value = $value;
    }

    /**
     * Get value.
     */
    public function getValue(): int {
        return $this->value;
    }

    /**
     * Assert validation.
     */
    private function assertGteIsValid(int $value) {
        if ($value < 0) {
            throw new \InvalidArgumentException(
                "Gte must be greater than or equal to zero."
            );
        }
    }

    /**
     * Convert to string.
     */
    public function __toString(): string {
        return (string) $this->value;
    }
}
