<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Application\UseCase\GetNewsList\GetNewsListUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetNewsListController extends AbstractFOSRestController
{
    public function __construct(
        private GetNewsListUseCase $useCase,
    ) {
    }

    #[Route('/api/v1/news/list', name: 'list_news', methods: ['GET'])]
    public function __invoke(): Response
    {
        try {
            $response = ($this->useCase)();
            return new Response(json_encode($response, JSON_UNESCAPED_UNICODE), 201);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return new Response(json_encode($errorResponse), 400);
        }
    }
}
