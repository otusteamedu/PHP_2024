<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\CreateAccount\CreateAccountRequest;
use App\Application\UseCase\CreateAccount\CreateAccountUseCase;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/v1/account/add',
    name: 'account_add',
    methods: ['POST']
)]
#[OA\Response(
    response: 200,
    description: 'Returns accountId',
    content: new OA\JsonContent(
        type: 'int'
    )
)]
#[Security(name: 'Bearer')]
final class AddAccountController extends AbstractController
{
    public function __construct(
        private readonly CreateAccountUseCase $useCase,
    ) {
    }

    /**
     * @param CreateAccountRequest $request
     * @return JsonResponse
     */
    public function __invoke(#[MapRequestPayload] CreateAccountRequest $request): JsonResponse
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