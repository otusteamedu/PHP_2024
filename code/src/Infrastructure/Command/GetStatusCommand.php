<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Command;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Viking311\Api\Application\UseCase\GetStatus\GetStatusRequest;
use Viking311\Api\Application\UseCase\GetStatus\GetStatusUseCase;

readonly class GetStatusCommand
{
    public function __construct(
        private GetStatusUseCase $useCase
    ) {
    }

    public function execute(Request $request, Response $response, string $eventId): Response
    {
        $useCaseRequest = new GetStatusRequest($eventId);
        $useCaseResponse = ($this->useCase)($useCaseRequest);

        $response
            ->getBody()
            ->write(
                json_encode($useCaseResponse)
            );

        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
