<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Domain\Entity\BankStatement;
use App\Domain\Entity\BankStatementData;
use App\Application\Services\GenerateBankStatementInterface;

class GenerateBankStatementService implements GenerateBankStatementInterface
{
    public function generate(array $message): BankStatementData
    {
        //какая-то обработка параметров, генерация html с данными на выходе как объект BankStatementData
        return new BankStatementData();
    }
}
