<?php

namespace app\Domain\ValueObject;

class AmountValueObject
{
    public string $amount;

    public function __construct(string $amount)
    {
        $this->validate($amount);
        $this->amount = $amount;
    }

    private function validate(string $amount): void
    {
        if (!preg_match('/^\d+(\.\d{1,2})?$/', $amount)) {
            throw new \InvalidArgumentException('Amount must be a valid decimal number');
        }
    }
}
