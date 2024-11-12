<?php

namespace VSukhov\Hw12\Domain\ValueObject;
class Stock
{
    private int $quantity;

    public function __construct(int $quantity)
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException("Stock quantity cannot be negative.");
        }

        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }
}
