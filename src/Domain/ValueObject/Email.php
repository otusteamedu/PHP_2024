<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Domain\ValueObject;

class Email
{
    public function __construct(public readonly $email)
    {
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
