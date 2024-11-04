<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\CreateNews\CreateNewsUseCase;
use App\Application\UseCase\CreateNews\CreateNewsRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class CreateNewsController extends AbstractFOSRestController
{
    public function __construct(
        private CreateNewsUseCase $useCase,
    ) {
    }

    #[Route('/api/v1/news/add', name: 'create_news', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] CreateNewsRequest $request
    ): Response {
        try {
            $response = ($this->useCase)($request);
            return new Response(
                json_encode(
                    [
                    'id' => $response->id
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
