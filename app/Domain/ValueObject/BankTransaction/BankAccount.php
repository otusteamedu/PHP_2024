<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\BankTransaction;

use App\Domain\Exception\Validate\TransactionAccountNumberException;

readonly final class BankAccount
{
    /**
     * @throws TransactionAccountNumberException
     */
    public function __construct(private string $accountNumber)
    {
        if (!strlen($this->accountNumber)) {
            throw new TransactionAccountNumberException();
        }
    }

    public function getValue(): string
    {
        return $this->accountNumber;
    }

    public function __toString(): string
    {
        return $this->accountNumber;
    }
}