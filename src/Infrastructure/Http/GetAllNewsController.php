<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetAllNewsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetAllNewsController extends AbstractController
{
    public function __construct(private GetAllNewsUseCase $useCase)
    {
    }

    #[Route('/api/v1/news', name: 'api_get_news', methods: ['GET'])]
    public function __invoke(): Response
    {
        try {
            $response = ($this->useCase)();
        } catch (\Throwable $e) {
            return $this->json(['Error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($response);
    }
}