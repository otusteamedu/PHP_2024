<?php

declare(strict_types=1);

namespace App\Application\Service\Task;

class PutTaskInQueueDto
{
    public function __construct(private int $taskId)
    {
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function toArray(): array
    {
        return ['taskId' => $this->taskId];
    }
}
