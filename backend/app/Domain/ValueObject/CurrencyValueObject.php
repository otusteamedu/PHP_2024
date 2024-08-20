<?php

namespace App\Domain\ValueObject;

class CurrencyValueObject
{
    public string $currencyCode;

    public function __construct(string $currencyCode)
    {
        $this->validate($currencyCode);
        $this->currencyCode = $currencyCode;
    }

    private function validate(string $currencyCode): void
    {

        if (!preg_match('/[A-Za-z_]+/', $currencyCode)) {
            throw new \InvalidArgumentException('Invalid currency code');
        }

    }
}
