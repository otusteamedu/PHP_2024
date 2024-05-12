<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Http;

use Irayu\Hw15\Application;
use Irayu\Hw15\Infrastructure;
use Irayu\Hw15\Domain;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateReportNewsController extends JsonController
{
    private Application\UseCase\CreateReportNewsUseCase $useCase;

    public function __construct(
        Infrastructure\Repository\FileNewsRepository $newsRepository,
        Infrastructure\Repository\FileReportRepository $reportRepository,
    ) {
        $this->useCase = new Application\UseCase\CreateReportNewsUseCase(
            $newsRepository,
            $reportRepository,
        );
    }

    protected function applyUseCase(Request $request, Response $response, array $args): array
    {
        $newsItemResponse = ($this->useCase)(
            new Application\UseCase\Request\CreateReportNewsItemRequest(
                $request->getParsedBody()['id'],
            )
        );

        return [
            'url' => '/api/news/report/get/' . $newsItemResponse->id . '/' . $newsItemResponse->hash,
        ];
    }
}
