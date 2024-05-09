<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

/**
 * Lte value object.
 */
class Lte
{
    /**
     * Value.
     */
    private int $value;

    /**
     * Construct.
     */
    public function __construct(int $value) {
        $this->assertLteIsValid($value);
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
    private function assertLteIsValid(int $value) {
        if ($value < 0) {
            throw new \InvalidArgumentException(
                "Lte must be greater than or equal to zero."
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
