<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\SubmitBankStatementUseCase;
use App\Application\UseCase\SubmitBankStatementUseCaseRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class BankStatementController extends AbstractController
{
    public function __construct(
        private readonly SubmitBankStatementUseCase $useCase
    )
    {
    }

    #[Route(path: '/statement', name: 'statement', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] SubmitBankStatementUseCaseRequest $request): JsonResponse
    {
        try {
            $response = ($this->useCase)($request);

            return $this->json($response, 201);
        } catch (Throwable $exception) {
            $errorResponse = [
                'message' => $exception->getMessage(),
            ];
            return $this->json($errorResponse, 400);
        }
    }
}
