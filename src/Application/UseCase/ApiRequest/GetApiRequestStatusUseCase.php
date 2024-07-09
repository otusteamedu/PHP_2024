<?php

declare(strict_types=1);

namespace App\Application\UseCase\ApiRequest;

use App\Application\UseCase\ApiRequest\DTO\StatusRequest;
use App\Application\UseCase\ApiRequest\DTO\StatusResponse;
use App\Domain\Entity\ApiRequest\ApiRequestRepositoryInterface;

class GetApiRequestStatusUseCase
{
    public function __construct(private ApiRequestRepositoryInterface $repository)
    {
    }

    public function __invoke(StatusRequest $request): StatusResponse
    {
        $apiRequest = $this->repository->find($request->id);

        return new StatusResponse($apiRequest->getStatus()->value);
    }
}
