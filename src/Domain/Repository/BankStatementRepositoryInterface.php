<?php

declare(strict_types=1);

namespace Alogachev\Homework\Domain\Repository;

use Alogachev\Homework\Domain\Entity\BankStatement;
use Alogachev\Homework\Domain\Repository\Query\FindBankStatementQuery;
use Alogachev\Homework\Domain\Repository\Query\UpdateStatusToReadyQuery;

interface BankStatementRepositoryInterface
{
    public function save(BankStatement $bankStatement): int;
    public function updateStatus(UpdateStatusToReadyQuery $query): void;

    public function findById(FindBankStatementQuery $query): ?BankStatement;
}
