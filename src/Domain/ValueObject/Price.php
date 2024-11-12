<?php

namespace VSukhov\Hw12\Domain\ValueObject;

class Price
{
    private int $amount;

    public function __construct(int $amount)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException("Price cannot be negative.");
        }

        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function format(): string
    {
        return number_format($this->amount / 100, 2, '.', '') . ' ₽';
    }
}