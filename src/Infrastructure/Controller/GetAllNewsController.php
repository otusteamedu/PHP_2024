<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\GetAllNewsUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class GetAllNewsController
{
    public function __construct(private GetAllNewsUseCase $getAllNewsUseCase)
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $getAllNewsResponse = ($this->getAllNewsUseCase)();

        $response->getBody()->write(json_encode($getAllNewsResponse));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
