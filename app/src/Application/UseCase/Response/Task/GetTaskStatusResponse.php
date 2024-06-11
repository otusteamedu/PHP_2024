<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response\Task;

use App\Domain\Enum\TaskStatus;

class GetTaskStatusResponse
{
    public function __construct(private TaskStatus $taskStatus)
    {
    }

    public function getTaskStatus(): TaskStatus
    {
        return $this->taskStatus;
    }
}
