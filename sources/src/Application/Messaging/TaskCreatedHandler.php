<?php

declare(strict_types=1);

namespace App\Application\Messaging;

use App\Domain\ValueObject\StatusEnum;
use App\Infrastructure\Persistence\TaskRepository;

class TaskCreatedHandler
{
    public function handle(array $message): void
    {
        sleep(10); // имитация задержки

        $taskId = $message['taskId'];

        $repository = new TaskRepository(); // TODO через контейнер\

        $task = $repository->findOneById($taskId);
        if ($task === null) return;

        $task->setStatus(StatusEnum::COMPLETED->value);

        $repository->save($task);
    }
}