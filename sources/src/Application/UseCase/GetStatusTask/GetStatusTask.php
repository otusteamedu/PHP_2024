<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetStatusTask;

use App\Domain\Repository\TaskRepositoryInterface;

readonly class GetStatusTask
{
    public function __construct(
        private TaskRepositoryInterface $repository
    ){
    }

    public function __invoke(GetStatusTaskRequest $request): GetStatusTaskResponse
    {
        $task = $this->repository->findOneById($request->id);

        return new GetStatusTaskResponse($task->getStatus());
    }
}
