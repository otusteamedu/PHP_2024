<?php

namespace Src\Infrastructure\Repository;

use Src\Domain\Repository\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function findByDateAndUserId(int $user_id, \DateTime $date): array
    {
        $transactions = [];
        if (rand(0,1) !== 0) {
            for ($i = 0; $i < rand(0, 3); $i++) {
                $transactions[] = [
                    'id' => md5($user_id.$date->format('Y-m-d').$i)
                ];
            }
        }
        return $transactions;
    }
}