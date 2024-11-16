<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\BankStatement;

class SubmitStatementRequest extends BankStatement
{
    public function __construct(public readonly string $account, public readonly string $dateFrom, public readonly string $dateTo, public readonly string $dateTime, public readonly string $email = "")
    {
    }
}
