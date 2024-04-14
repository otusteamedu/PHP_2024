<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\AddNewsUseCase;
use App\Application\UseCase\Request\AddNewsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddNewsController extends AbstractController
{
    public function __construct(private AddNewsUseCase $useCase)
    {
    }

    #[Route('/api/v1/news', name: 'api_add_news', methods: ['POST'])]
    public function __invoke(AddNewsRequest $request): Response
    {
        try {
            $response = ($this->useCase)($request);
        } catch (\Throwable $e) {
            return $this->json(['Error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($response);
    }
}