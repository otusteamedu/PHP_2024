<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitTask;

use App\Application\Messaging\MessageSenderInterface;
use App\Domain\Factory\TaskFactoryInterface;
use App\Domain\Repository\TaskRepositoryInterface;

readonly class SubmitTask
{
    public function __construct(
        private TaskRepositoryInterface $repository,
        private TaskFactoryInterface    $taskFactory,
        private MessageSenderInterface  $messageSender,
    ){
    }

    public function __invoke(SubmitTaskRequest $request): SubmitTaskResponse
    {
        $task = $this->taskFactory->create($request->title);

        $this->repository->save($task);

        $this->messageSender->send(
            'task_queue',
            ['taskId' => $task->getId(), 'action' => 'task.created'],
            'task_exchange',
            'task.created'
        );

        return new SubmitTaskResponse($task->getId());
    }
}
