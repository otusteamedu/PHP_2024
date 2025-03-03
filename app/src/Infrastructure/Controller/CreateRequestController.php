<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\CreateRequest\CreateRequestRequest;
use App\Application\UseCase\CreateRequest\CreateRequestUseCase;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/v1/request',
    name: 'request_add',
    methods: ['POST']
)]
#[OA\Response(
    response: 200,
    description: 'Returns requestId',
    content: new OA\JsonContent(
        type: 'int'
    )
)]
#[OA\Response(
    response: 400,
    description: 'Bad request, invalid input data',
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'message', type: 'string')
        ]
    )
)]
#[Security(name: 'Bearer')]
final class CreateRequestController extends AbstractController
{
    public function __construct(
        private readonly CreateRequestUseCase $useCase,
    ) {
    }

    /**
     * @param CreateRequestRequest $request
     * @return JsonResponse
     */
    public function __invoke(#[MapRequestPayload] CreateRequestRequest $request): JsonResponse
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
