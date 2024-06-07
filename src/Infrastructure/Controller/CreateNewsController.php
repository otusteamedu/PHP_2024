<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\CreateNewsUseCase;
use App\Application\UseCase\Request\CreateNewsRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class CreateNewsController
{
    public function __construct(private CreateNewsUseCase $createNewsUseCase, private CreateNewsRequest $createNewsRequest)
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $createNewsResponse = ($this->createNewsUseCase)($this->createNewsRequest);

        $response->getBody()->write(json_encode($createNewsResponse));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
