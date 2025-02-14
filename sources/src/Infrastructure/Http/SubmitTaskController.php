<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\SubmitTask\SubmitTask;
use App\Application\UseCase\SubmitTask\SubmitTaskRequest;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

readonly class SubmitTaskController
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private SubmitTask               $submitTaskUseCase
    )
    {
    }

    public function __invoke(Request $request): Response
    {

        $data = $request->getParsedBody();
        $payload = ($this->submitTaskUseCase)(new SubmitTaskRequest($data['title']));

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json');
    }
}