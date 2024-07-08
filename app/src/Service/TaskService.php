<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\TaskRequestDto;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $repository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function createTask(TaskRequestDto $dto): Task
    {
        $task = new Task($dto->name, $dto->email);
        $this->repository->save($task);

        return $task;
    }

    public function completeTask(int $taskId): void
    {
        $task = $this->repository->find($taskId);

        if (!$task instanceof Task) {
            $this->logger->error(sprintf('Task with id "%s" not found', $taskId));

            return;
        }

        $task->makeCompleted();
        $this->repository->flush();
    }

    public function putTask(Task $task, TaskRequestDto $dto): Task
    {
        $task
            ->setName($dto->name)
            ->setEmail($dto->email);
        $this->repository->flush();

        return $task;
    }

    public function patchTask(Task $task, array $parameters): Task
    {
        $propertyAccessor = $this->getPropertyAccessor();

        foreach ($parameters as $property => $value) {
            $propertyAccessor->setValue($task, $property, $value);
        }

        return $task;
    }

    private function getPropertyAccessor(): PropertyAccessorInterface
    {
        return PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->getPropertyAccessor();
    }
}
