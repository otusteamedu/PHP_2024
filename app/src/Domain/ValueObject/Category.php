<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

/**
 * Category value object.
 */
class Category {
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
