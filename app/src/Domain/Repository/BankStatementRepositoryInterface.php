<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\BankStatement;

interface BankStatementRepositoryInterface
{
    public function findById(int $id): array;

    public function save(BankStatement $bankStatement): void;

    public function setStatusProcess(int $id): void;

    public function setStatusDone(int $id): void;
}
