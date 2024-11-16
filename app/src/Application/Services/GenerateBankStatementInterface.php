<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Entity\BankStatement;
use App\Domain\Entity\BankStatementData;

interface GenerateBankStatementInterface
{
    public function generate(array $message): BankStatementData;
}
