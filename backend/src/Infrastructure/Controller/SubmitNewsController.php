<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\SubmitNews\SubmitNewsRequest;
use App\Application\UseCase\SubmitNews\SubmitNewsUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubmitNewsController
{
    public function __construct(
        public SubmitNewsUseCase $useCase,
    ) {
    }

    #[Route('/api/v1/news/add', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $submitRequest = new SubmitNewsRequest($data['url']);

        try {
            $response = ($this->useCase)($submitRequest);
            return new Response(json_encode([
                'id' => $response->id,
            ]), 201);
        } catch (\Throwable $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 400);
        }
    }
}
