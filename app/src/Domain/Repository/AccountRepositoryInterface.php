<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function findById(int $id): ?Account;

    public function save(Account $account): void;

}
