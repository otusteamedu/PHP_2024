<?php

declare(strict_types=1);

namespace App\Domain\Enum\BankTransaction;

enum TransactionTypeEnum: string
{
    case TRANSACTION = 'transaction';
    case REFUND = 'refund';
}
