<?php

declare(strict_types=1);

namespace App\Application\Actions\CustomerTask;

use Psr\Http\Message\ResponseInterface as Response;

class ViewCustomerTaskStatusAction extends CustomerTaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $taskId = $this->resolveArg('id');
        $taskStatus = $this->customerTasksRepository->getTaskStatus($taskId);

        $this->logger->info("Task of id `{{$taskId}}` was viewed.");

        return $this->respondWithData($taskStatus);
    }
}
