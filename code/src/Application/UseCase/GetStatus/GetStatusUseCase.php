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

    public function __invoke(GetStatusRequest $request): GetStatusResponse
    {
        $event = $this->repository->getById($request->id);
         if (is_null($event)) {
             return new GetStatusResponse(null);
         }

         return new GetStatusResponse(
             $event->getStatus()
         );
    }

}
