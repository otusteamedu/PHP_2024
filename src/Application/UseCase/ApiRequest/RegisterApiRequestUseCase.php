<?php

declare(strict_types=1);

namespace App\Application\UseCase\ApiRequest;

use App\Application\UseCase\ApiRequest\DTO\RegisterRequest;
use App\Application\UseCase\MessageBrokerInterface;
use App\Domain\Entity\ApiRequest\{ApiRequest, ApiRequestRepositoryInterface};
use App\Domain\Enum\ApiRequestStatuses;
use App\Domain\ValueObject\ApiRequestBody;

class RegisterApiRequestUseCase
{
    public function __construct(
        private MessageBrokerInterface $messageBroker,
        private ApiRequestRepositoryInterface $repository
    ) {
    }

    public function __invoke(RegisterRequest $request): int
    {
        $apiRequest = new ApiRequest(new ApiRequestBody($request->body), ApiRequestStatuses::IN_PROGRESS);

        $this->repository->store($apiRequest);

        $this->pushToQueue([
            'id' => $apiRequest->getId(),
            'body' => $apiRequest->getBody()->getValue(),
        ]);

        return $apiRequest->getId();
    }

    private function pushToQueue(array $data): void
    {
        $this->messageBroker->publish($data);
    }
}
