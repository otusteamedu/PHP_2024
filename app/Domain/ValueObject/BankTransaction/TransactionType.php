<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\BankTransaction;

use App\Domain\Enum\BankTransaction\TransactionTypeEnum;
use App\Domain\Exception\Validate\TransactionTypeException;

final class TransactionType
{
    /**
     * @throws TransactionTypeException
     */
    public function __construct(string $type, private ?TransactionTypeEnum $transactionType = null)
    {
        $this->transactionType = TransactionTypeEnum::tryFrom($type);

        if (!$this->transactionType) {
            throw new TransactionTypeException();
        }
    }

    public function getValue(): TransactionTypeEnum
    {
        return $this->transactionType;
    }

    public function __toString(): string
    {
        return (string) $this->transactionType->value;
    }
}