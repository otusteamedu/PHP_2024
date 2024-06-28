<?php

declare(strict_types=1);

namespace App\Domain\CustomerTask;

use App\Domain\CustomerTask\Task;

interface TaskRepositoryInterface
{
    /**
     * @return string
     */
    public function create(Task $task): string;

    /**
     * @param string $id
     * @return string
     * @throws TaskNotFoundException
     */
    public function getTaskStatus(string $id): string;
}
