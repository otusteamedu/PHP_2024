<?php

declare(strict_types=1);

namespace App\Application\UseCase\Task;

use App\Application\UseCase\BaseUseCase;
use App\Application\UseCase\Exception\NotFoundException;
use App\Application\UseCase\Exception\RequestValidationException;
use App\Application\UseCase\Request\Task\GetTaskStatusRequest;
use App\Application\UseCase\Response\Task\GetTaskStatusResponse;
use App\Application\Service\RequestValidationServiceInterface;
use App\Domain\Repository\TaskRepositoryInterface;

class GetTaskStatusUseCase extends BaseUseCase
{
    public function __construct(
        private RequestValidationServiceInterface $requestValidationService,
        private TaskRepositoryInterface $taskRepository
    ) {
        parent::__construct();
    }

    /**
     * @throws NotFoundException|RequestValidationException
     */
    public function __invoke(GetTaskStatusRequest $request): GetTaskStatusResponse
    {
        $this->checkRequestValidationErrors($this->requestValidationService->validateGetTaskStatusRequest($request));
        $task = $this->taskRepository->findById($request->getId());
        if ($task === null) {
            throw new NotFoundException();
        }

        return new GetTaskStatusResponse($task->getStatus());
    }
}
