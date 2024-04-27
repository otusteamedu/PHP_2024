<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

/**
 * Shop value object.
 */
class Shop {
  /**
   * Value.
   */
  private string $value;

  /**
   * Construct.
   */
  public function __construct(string $value) {
    $this->value = $value;
  }

  /**
   * Get value.
   */
  public function getValue(): string {
    return $this->value;
  }

  /**
   * Convert to string.
   */
  public function __toString(): string {
    return $this->value;
  }

}
