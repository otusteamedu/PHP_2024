<?php

declare(strict_types=1);

namespace App\Application\Actions\CustomerTask;

use App\Domain\CustomerTask\Task;
use Psr\Http\Message\ResponseInterface as Response;

class CreateCustomerTaskAction extends CustomerTaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $taskName = $this->resolveBodyArg('name');
        $taskDescription = $this->resolveBodyArg('description');
        $task = new Task(null, $taskName, $taskDescription);
        $taskId = $this->customerTasksRepository->create($task);
        $this->logger->info("Task of id `{{$taskId}}` was created.");

        return $this->respondWithData($taskId);
    }
}
