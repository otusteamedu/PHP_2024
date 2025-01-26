<?php

namespace Src\Domain\Repository;

interface TransactionRepositoryInterface
{
    public function findByDateAndUserId(int $user_id, \DateTime $date): array;
}
