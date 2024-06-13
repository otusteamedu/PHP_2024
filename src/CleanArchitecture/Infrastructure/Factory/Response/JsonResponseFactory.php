<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response;

use Psr\Http\Message\ResponseInterface as Response;

class JsonResponseFactory
{
    public function createResponse(Response $response, array|object $value, int $statusCode = 200): Response
    {
        $response = $response
            ->withStatus($statusCode)
            ->withHeader('Content-type', 'application-json');

        $response->getBody()->write(json_encode($value));
        return $response;
    }

    public function createErrorsResponse(Response $response, array|object $value, int $statusCode = 500): Response
    {
        return $this->createResponse($response, ['errors' => $value], $statusCode);
    }

    public function createGeneralErrorsResponse(Response $response, array $messages, int $statusCode = 500): Response
    {
        return $this->createErrorsResponse($response, ['general' => $messages], $statusCode);
    }

    public function createGeneralErrorResponse(Response $response, string $message, int $statusCode = 500): Response
    {
        return $this->createGeneralErrorsResponse($response, [$message], $statusCode);
    }

    public function createDefaultGeneralErrorResponse(Response $response, int $statusCode = 500): Response
    {
        return $this->createGeneralErrorResponse($response, 'Произошла ошибка', $statusCode);
    }
}
