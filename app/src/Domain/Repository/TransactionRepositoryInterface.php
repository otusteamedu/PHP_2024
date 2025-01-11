<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function findById(int $id): ?Transaction;

    public function save(Transaction $transaction): void;

    public function findForStatement(int $accountId, string $dateFrom, string $dateTo): iterable;

}