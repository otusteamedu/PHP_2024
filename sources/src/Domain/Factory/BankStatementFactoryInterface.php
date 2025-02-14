<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\BankStatement;

interface BankStatementFactoryInterface
{
    public function create(int $account,string $title, string $date): BankStatement;
}
