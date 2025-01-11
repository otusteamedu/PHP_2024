<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Statement;
use App\Infrastructure\Entity\StatusEnum;

interface StatementRepositoryInterface
{
    public function findById(int $id): ?Statement;

    public function save(Statement $statement): void;

}
