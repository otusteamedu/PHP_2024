<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\GetStatus;

use Viking311\Api\Domain\Repository\EventRepositoryInterface;

readonly class GetStatusUseCase
{
    public function __construct(
        private EventRepositoryInterface $repository
    ) {
    }

    public function __invoke(GetStatusRequest $request): GetStausResponse
    {
        $event = $this->repository->getById($request->id);
         if (is_null($event)) {
             return new GetStausResponse(null);
         }

         return new GetStausResponse(
             $event->getStatus()
         );
    }

}
