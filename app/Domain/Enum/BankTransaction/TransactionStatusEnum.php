<?php

declare(strict_types=1);

namespace App\Domain\Enum\BankTransaction;

enum TransactionStatusEnum: string
{
    case FAILURE = 'failure';
    case SUCCESS = 'success';
}
