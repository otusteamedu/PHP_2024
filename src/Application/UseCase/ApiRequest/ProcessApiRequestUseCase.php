<?php

declare(strict_types=1);

namespace App\Application\UseCase\ApiRequest;

use App\Application\UseCase\ApiRequest\DTO\RegisterRequest;
use App\Application\UseCase\MessageProcessable;
use App\Domain\Entity\ApiRequest\{ApiRequest, ApiRequestRepositoryInterface};
use App\Domain\Enum\ApiRequestStatuses;

class ProcessApiRequestUseCase implements MessageProcessable
{
    public function __construct(private ApiRequestRepositoryInterface $repository)
    {
    }

    public function __invoke(RegisterRequest $request): void
    {

        $apiRequest = $this->repository->find($request->id);

        $apiRequest = $this->processRequest($apiRequest);

        $this->repository->update($apiRequest);
    }

    private function processRequest(ApiRequest $request): ApiRequest
    {
        // some logic
        $randomStatus = collect(ApiRequestStatuses::cases())->random();

        $request->setStatus($randomStatus);

        return $request;
    }
}
