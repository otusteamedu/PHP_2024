<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\GenerateReportUseCase;
use App\Application\UseCase\Request\GenerateReportRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final readonly class GenerateReportController
{
    public function __construct(
        private GenerateReportUseCase $generateReportUseCase,
        private GenerateReportRequest $generateReportRequest
    ) {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $generateReportResponse = ($this->generateReportUseCase)($this->generateReportRequest);

        $response->getBody()->write(json_encode($generateReportResponse));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
