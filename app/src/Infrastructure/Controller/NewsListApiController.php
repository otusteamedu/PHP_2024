<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\GetAllNewsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class NewsListApiController extends AbstractController
{
    public function __construct(private readonly GetAllNewsUseCase $getAllNewsUseCase)
    {
    }

    #[Route('/news', methods: ['GET'])]
    public function indexAction(): JsonResponse
    {
        $newsListResponseDto = ($this->getAllNewsUseCase)();

        return $this->json($newsListResponseDto);
    }
}
