<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\CreateAccount\CreateAccountRequest;
use App\Application\UseCase\CreateAccount\CreateAccountUseCase;
use App\Application\UseCase\CreateStatement\CreateStatementRequest;
use App\Application\UseCase\CreateStatement\CreateStatementUseCase;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/v1/statement/get',
    name: 'statement_get',
    methods: ['POST']
)]
final class GetStatementController extends AbstractController
{
    public function __construct(
        private readonly CreateStatementUseCase $useCase,
    ) {
    }

    /**
     * @param CreateStatementRequest $request
     * @return JsonResponse
     */
    public function __invoke(#[MapRequestPayload] CreateStatementRequest $request): JsonResponse
    {
        try {
            $response = ($this->useCase)($request);
            return $this->json($response);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return $this->json($errorResponse, 400);
        }
    }
}