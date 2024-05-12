<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Http;

use Irayu\Hw15\Application;
use Irayu\Hw15\Domain;
use Irayu\Hw15\Infrastructure;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetReportNewsController
{
    private Application\UseCase\GetReportNewsUseCase $useCase;

    public function __construct(
        Infrastructure\Repository\FileNewsRepository $newsRepository,
        Infrastructure\Repository\FileReportRepository $reportRepository,
    ) {
        $this->useCase = new Application\UseCase\GetReportNewsUseCase(
            $newsRepository,
            $reportRepository,
        );
    }

    protected function applyUseCase(Request $request, Response $response, array $args): string
    {
        $newsItemResponse = ($this->useCase)(
            new Application\UseCase\Request\GetReportNewsItemRequest(
                (int) $args['id'],
                (string) $args['hash'],
            )
        );

        $items = array_map(
            fn(Domain\Entity\NewsItem $item) =>
                '<li><a href="' . htmlspecialchars($item->getUrl()->getValue()) . '">'
                    . $item->getTitle()->getValue() . '</a></li>',
            $newsItemResponse->items,
        );

        return '<ul>' . implode('', $items) . '</ul>';
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $file = 'report.html';
            $result = $this->applyUseCase($request, $response, $args);

            $response->getBody()->write($result);
            return $response
                ->withHeader('Content-Description', 'File Transfer')
                ->withHeader('Content-Type', 'application/octet-stream')
                ->withHeader('Content-Type', 'application/download')
                ->withHeader('Content-Disposition', 'attachment;filename="' . basename($file) . '"')
                ->withHeader('Expires', '0')
                ->withHeader('Cache-Control', 'must-revalidate')
                ->withHeader('Pragma', 'public')
                ->withHeader('Content-Length', strlen($result))
                ->withStatus(201)
            ;
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
