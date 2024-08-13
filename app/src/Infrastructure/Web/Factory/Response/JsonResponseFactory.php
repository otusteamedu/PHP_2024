<?php

declare(strict_types=1);

namespace App\Infrastructure\Web\Factory\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonResponseFactory
{
    public function createResponse(array|object $data, int $statusCode = 200): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }

    public function createErrorsResponse(array|object $data, int $statusCode = 500): JsonResponse
    {
        return $this->createResponse(['errors' => $data], $statusCode);
    }

    public function createGeneralErrorsResponse(array $messages, int $statusCode = 500): JsonResponse
    {
        return $this->createErrorsResponse(['general' => $messages], $statusCode);
    }

    public function createGeneralErrorResponse(string $message, int $statusCode = 500): JsonResponse
    {
        return $this->createGeneralErrorsResponse([$message], $statusCode);
    }

    public function createDefaultGeneralErrorResponse(int $statusCode = 500): JsonResponse
    {
        return $this->createGeneralErrorResponse('Произошла ошибка', $statusCode);
    }
}
