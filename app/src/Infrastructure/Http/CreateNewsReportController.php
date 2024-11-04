<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\CreateNewsReport\CreateNewsReportUseCase;
use App\Application\UseCase\CreateNewsReport\CreateNewsReportRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class CreateNewsReportController extends AbstractFOSRestController
{
    public function __construct(
        private CreateNewsReportUseCase $useCase,
    ) {
    }

    #[Route('/api/v1/news/report', name: 'create_report', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        try {
            // тут не смог через MapRequestPayload преобразовать сразу в CreateNewsReportRequest, поэтому через костыль
            $ids = $request->get('ids');
            $response = ($this->useCase)(new CreateNewsReportRequest($ids));
            // для упрощения - ссылка на файл возвращается относительно пути на сервере, но можно сделать и относительно public, если hostname получить или задать
            return new Response(
                json_encode(
                    [
                    'filePath' => $response->filePath,
                    ]
                ),
                201
            );
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return new Response(json_encode($errorResponse), 400);
        }
    }
}
