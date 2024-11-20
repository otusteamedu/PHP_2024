<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dictionary\QueueDictionary;
use App\Entity\RequestEntity;
use App\Producer\ProducerInterface;
use App\Repository\RequestRepository;
use App\UseCase\Request\CreateRequest;
use App\UseCase\Response\CreateResponse;
use App\ValueObject\DataValueObject;
use App\ValueObject\IdValueObject;
use App\ValueObject\StatusValueObject;

readonly class CreateRequestUseCase
{
    public function __construct(private ProducerInterface $producerService, private RequestRepository $requestRepository)
    {
    }

    public function addRequest(CreateRequest $createRequest): CreateResponse
    {
        $request = new RequestEntity(
            IdValueObject::generate(),
            new DataValueObject($createRequest->data),
            StatusValueObject::Pending
        );
        $this->requestRepository->createRequest($request);
        $this->producerService->publish(['id' => $request->getId()->value], QueueDictionary::RequestQueue->value);
        return new CreateResponse($request->getId()->value);
    }
}
