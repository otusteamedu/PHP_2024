<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\GetStatementUseCase\GetRequestRequest;
use App\Application\UseCase\GetStatementUseCase\GetRequestResponse;
use App\Application\UseCase\GetStatementUseCase\GetRequestUseCase;
use InvalidArgumentException;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

#[Route(
    '/api/v1/request',
    name: 'request_get',
    methods: ['GET']
)]
#[OA\Response(
    response: 200,
    description: 'Successful response',
    content: new Model(type: GetRequestResponse::class)
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

final class GetRequestController extends AbstractController
{
    public function __construct(
        private readonly GetRequestUseCase $useCase,
    ) {
    }

    /**
     * @param GetRequestRequest $request
     * @return JsonResponse
     */
    public function __invoke(#[MapQueryString] GetRequestRequest $request): JsonResponse
    {
        try {
            $response = ($this->useCase)($request);
            return $this->json($response);
        }
        catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return $this->json($errorResponse, 400);
        }
    }
}
