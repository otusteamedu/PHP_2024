<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Http;

use Irayu\Hw15\Application;
use Irayu\Hw15\Infrastructure;
use Irayu\Hw15\Domain;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class JsonController
{
    abstract protected function applyUseCase(Request $request, Response $response, array $args): array;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $result = $this->applyUseCase($request, $response, $args);
            $response->getBody()->write(json_encode($result));
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            $response->withStatus(400);
            $response->getBody()->write(json_encode($errorResponse));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}
