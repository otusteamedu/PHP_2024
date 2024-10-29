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
    public function __construct(
        protected Infrastructure\Repository\FileReportRepository $reportRepository,
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $file = 'report.html';
            $result = $this->reportRepository->findFileByHash($args['hash']);

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
                ->withStatus(200)
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
