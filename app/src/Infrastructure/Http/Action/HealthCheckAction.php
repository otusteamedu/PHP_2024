<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Infrastructure\Manager\ConnectionManager;

class HealthCheckAction
{
    public function __construct(
        protected ConnectionManager $connection
    ) {
    }
    public function __invoke(Request $request, Response $response): Response
    {
        $status = $this->connection->getStatus();

        $response->getBody()->write($status);

        return $response;
    }
}
