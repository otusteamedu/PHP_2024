<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\BankTransaction;

use App\Domain\Enum\BankTransaction\TransactionStatusEnum;
use App\Domain\Exception\Validate\TransactionStatusException;

final class TransactionStatus
{
    /**
     * @throws TransactionStatusException
     */
    public function __construct(string $status, private ?TransactionStatusEnum $transactionStatus = null)
    {
        $this->transactionStatus = TransactionStatusEnum::tryFrom($status);

        if (!$this->transactionStatus) {
            throw new TransactionStatusException();
        }
    }

    public function getValue(): TransactionStatusEnum
    {
        return $this->transactionStatus;
    }

    public function __toString(): string
    {
        return $this->transactionStatus->value;
    }
}
