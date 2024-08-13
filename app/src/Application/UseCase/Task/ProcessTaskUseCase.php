<?php

declare(strict_types=1);

namespace App\Application\UseCase\Task;

use App\Application\Service\RequestValidationServiceInterface;
use App\Application\UseCase\BaseUseCase;
use App\Application\UseCase\Exception\NotFoundException;
use App\Application\UseCase\Exception\RequestValidationException;
use App\Application\UseCase\Request\Task\ProcessTaskRequest;
use App\Domain\Enum\TaskStatus;
use App\Domain\Exception\ValidationException;
use App\Domain\Service\EntityValidationServiceInterface;
use App\Domain\Repository\TaskRepositoryInterface;

class ProcessTaskUseCase extends BaseUseCase
{
    public function __construct(
        private RequestValidationServiceInterface $requestValidationService,
        private EntityValidationServiceInterface $entityValidationService,
        private TaskRepositoryInterface $taskRepository,
    ) {
        parent::__construct();
    }

    /**
     * @throws NotFoundException|RequestValidationException|ValidationException
     */
    public function __invoke(ProcessTaskRequest $request): void
    {
        $this->checkRequestValidationErrors($this->requestValidationService->validateProcessTaskRequest($request));

        $task = $this->taskRepository->findById($request->getId());
        if ($task === null) {
            throw new NotFoundException();
        }

        $task->changeStatus(TaskStatus::PROCESSING);
        $this->checkValidationErrors($this->entityValidationService->validateTask($task));
        $this->taskRepository->save($task);

        sleep(10); // // Имитируем долгую обработку.

        $task->changeStatus(TaskStatus::COMPLETED);
        $this->checkValidationErrors($this->entityValidationService->validateTask($task));
        $this->taskRepository->save($task);
    }
}
