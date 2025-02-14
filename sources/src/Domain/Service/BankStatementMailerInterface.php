<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\BankStatement;

interface BankStatementMailerInterface
{
    public function sendBankStatement(array $bankStatements): void;
}
