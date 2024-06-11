<?php

declare(strict_types=1);

namespace App\Application\UseCase\Task;

use App\Application\UseCase\BaseUseCase;
use App\Application\UseCase\Exception\RequestValidationException;
use App\Application\UseCase\Request\Task\SendTaskRequest;
use App\Application\UseCase\Response\Task\SendTaskResponse;
use App\Application\Service\Task\PutTaskInQueueDto;
use App\Application\Service\Task\PutTaskInQueueServiceInterface;
use App\Domain\Entity\Task;
use App\Domain\Exception\ValidationException;
use App\Domain\Service\EntityValidationServiceInterface;
use App\Domain\Repository\TaskRepositoryInterface;
use App\Application\Service\RequestValidationServiceInterface;

class SendTaskUseCase extends BaseUseCase
{
    public function __construct(
        private RequestValidationServiceInterface $requestValidationService,
        private EntityValidationServiceInterface $entityValidationService,
        private TaskRepositoryInterface $taskRepository,
        private PutTaskInQueueServiceInterface $putTaskInQueueService
    ) {
        parent::__construct();
    }

    /**
     * @throws RequestValidationException|ValidationException
     */
    public function __invoke(SendTaskRequest $request): SendTaskResponse
    {
        $this->checkRequestValidationErrors($this->requestValidationService->validateSendTaskStatusRequest($request));
        $task = new Task($request->getBody());
        $this->checkValidationErrors($this->entityValidationService->validateTask($task));
        $this->taskRepository->save($task);
        $this->putTaskInQueueService->put(new PutTaskInQueueDto($task->getId()));
        return new SendTaskResponse($task->getId());
    }
}
