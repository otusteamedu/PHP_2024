<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetStatusTask\GetStatusTask;
use App\Application\UseCase\GetStatusTask\GetStatusTaskRequest;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

readonly class GetStatusTaskController
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private GetStatusTask            $getStatusTaskUseCase
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $data = $request->getParsedBody();
        $payload = ($this->getStatusTaskUseCase)(new GetStatusTaskRequest($data['id']));

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json');
    }
}