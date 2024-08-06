<?php

namespace App\Domain\ValueObject;

class AccountValueObject
{
    public string $account;

    public function __construct(string $account)
    {
        $this->validate($account);
        $this->account = $account;
    }

    private function validate(string $account): void
    {
        if (!preg_match('/[A-Za-z0-9]+/', $account)) {
            throw new \InvalidArgumentException('Invalid address');
        }
    }
}
