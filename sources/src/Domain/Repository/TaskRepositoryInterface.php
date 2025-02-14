<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Task;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;
    public function findOneById(string $id): ?Task;
}