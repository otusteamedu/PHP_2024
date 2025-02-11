<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetListNews\GetListNewsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class GetAllNewsController extends AbstractController
{
    public function __construct(
        private readonly GetListNewsUseCase $useCase
    )
    {
    }

    #[Route(path: '/news/all', name: 'news_all', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        try {
            $news = ($this->useCase)();

            return $this->json($news->getNews(), 201);
        } catch (Throwable $exception) {
            $errorResponse = [
                'message' => $exception->getMessage(),
            ];
            return $this->json($errorResponse, 400);
        }
    }
}