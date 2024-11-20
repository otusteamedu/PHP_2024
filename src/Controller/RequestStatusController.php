<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\RequestRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class RequestStatusController
{
    public function __construct(private RequestRepository $requestRepository)
    {
    }

    public function __invoke($id): JsonResponse
    {
        $status = $this->requestRepository->getRequestStatus($id);
        if ($status === null) {
            return new JsonResponse(['error' => 'Request not found'], 404);
        }
        return new JsonResponse(['status' => $status], 200);
    }
}
