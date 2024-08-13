<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Task;

interface TaskRepositoryInterface
{
    public function findById(int $id): ?Task;
    public function save(Task $task): void;
}
