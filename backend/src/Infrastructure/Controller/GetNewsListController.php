<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\GetNewsList\GetNewsListUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetNewsListController
{
    public function __construct(
        private readonly GetNewsListUseCase $useCase,
    ) {
    }

    #[Route('/api/v1/news/list', methods: ['GET'])]
    public function __invoke(): Response
    {
        try {
            $newsList = ($this->useCase)();
            return new Response(json_encode($newsList), 200, ['Content-Type' => 'application/json']);
        } catch (\Throwable $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 500);
        }
    }
}
