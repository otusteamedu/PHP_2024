<?php

declare(strict_types=1);

namespace Otus\Hw20\Infrastructure\Http\Api;

use Otus\Hw20\Application\UseCase\RequestStatementUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;

class StatementController extends AbstractController
{
    public function __construct(private RequestStatementUseCase $useCase)
    {
    }

    #[Route('/api/statement/request', name: 'api_statement_request', methods: ['POST'])]
    #[OA\Post(
        path: '/api/statement/request',
        summary: 'Create a new statement request',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2025-03-01'),
                    new OA\Property(property: 'end_date', type: 'string', format: 'date', example: '2025-03-10')
                ],
                type: 'object'
            )
        ), // Добавляем тег для группировки
        tags: ['Statement'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Request accepted',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'request_id', type: 'integer', example: 1)
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function createRequest(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $startDate = new \DateTime($data['start_date']);
        $endDate = new \DateTime($data['end_date']);

        $statementRequest = $this->useCase->execute($startDate, $endDate);

        return $this->json(['request_id' => $statementRequest->getId()], 201);
    }

    #[Route('/api/statement/{id}/status', name: 'api_statement_status', methods: ['GET'])]
    #[OA\Get(
        path: '/api/statement/{id}/status',
        summary: 'Get status of a statement request',
        tags: ['Statement'], // Добавляем тег для группировки
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'Request ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Request status',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'request_id', type: 'integer', example: 1),
                        new OA\Property(property: 'status', type: 'string', example: 'completed')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Request not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Request not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function getStatus(int $id): JsonResponse
    {
        $statementRequest = $this->useCase->getRepository()->find($id);

        if (!$statementRequest) {
            return $this->json(['error' => 'Request not found'], 404);
        }

        return $this->json([
            'request_id' => $statementRequest->getId(),
            'status' => $statementRequest->getStatus()
        ]);
    }
}
