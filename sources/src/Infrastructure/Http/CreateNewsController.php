<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\SubmitNews\SubmitNewsRequest;
use App\Application\UseCase\SubmitNews\SubmitNewsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class CreateNewsController extends AbstractController
{
    public function __construct(
        private readonly SubmitNewsUseCase $useCase
    )
    {
    }

    #[Route(path: '/news', name: 'news', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] SubmitNewsRequest $request): JsonResponse
    {
        try {
            $newsId = ($this->useCase)($request);

            return $this->json($newsId, 201);
        } catch (Throwable $exception) {
            $errorResponse = [
                'message' => $exception->getMessage(),
            ];
            return $this->json($errorResponse, 400);
        }
    }
}