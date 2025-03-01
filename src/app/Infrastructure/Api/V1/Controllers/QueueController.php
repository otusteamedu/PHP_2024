<?php

declare(strict_types=1);

namespace App\Infrastructure\Api\V1\Controllers;

use App\Application\Services\QueueService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Queue API",
 *     version="1.0.0",
 *     description="API для добавления запросов в очередь и проверки их статуса"
 * )
 */
readonly class QueueController
{
    public function __construct(private QueueService $queueService)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/v1/request",
     *     summary="Добавить запрос в очередь",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="string", example="example_data")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Запрос добавлен в очередь",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="request_id", type="string", example="req_60c5b1e8e6b3a")
     *         )
     *     )
     * )
     */
    public function addRequest(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody()['data'] ?? '';
        $requestId = $this->queueService->addToQueue($data);

        $response->getBody()->write(json_encode(['request_id' => $requestId]));
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/request/{id}",
     *     summary="Проверить статус запроса",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Идентификатор запроса",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Статус запроса",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запрос не найден",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Request not found")
     *         )
     *     )
     * )
     */
    public function getStatus(Request $request, Response $response, array $args): Response
    {
        $requestId = $args['id'];
        $status = $this->queueService->getStatus($requestId);

        if (is_null($status)) {
            $response->getBody()->write(json_encode(['error' => 'Request not found']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode(['status' => $status]));
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
