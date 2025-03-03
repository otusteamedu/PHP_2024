<?php

namespace App\Application\UseCase\CreateRequest;

use App\Domain\Factory\RequestFactoryInterface;
use App\Domain\Repository\RequestRepositoryInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class CreateRequestUseCase
{
    public function __construct(
        private readonly RequestFactoryInterface $requestFactory,
        private readonly RequestRepositoryInterface $requestRepository,
        private readonly ProducerInterface $producer
    ) {
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(CreateRequestRequest $request): CreateRequestResponse
    {
        $request = $this->requestFactory->create(
            $request->requesterName,
            $request->requesterEmail
        );
        $this->requestRepository->save($request);
        $this->producer->publish(
            json_encode(['requestId' => (int)$request->getId()], JSON_THROW_ON_ERROR, 512)
        );
        return new CreateRequestResponse(
            $request->getId()
        );
    }
}
