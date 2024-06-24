<?php

declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Request\CreateRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\UseCase\CreateRequestUseCase;

readonly class CreateRequestController
{
    public function __construct(
        private CreateRequestUseCase $createRequestUseCase,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $createRequest = new CreateRequest($data);
        $createResponse = $this->createRequestUseCase->addRequest($createRequest);
        return new JsonResponse(['request_id' => $createResponse->id], 200);
    }
}
