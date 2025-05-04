<?php

namespace App\Http\Controllers;

use App\Services\RabbitMQService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\Request\RequestEloquentRepository;
use OpenApi\Annotations as OA;

class RequestController extends Controller
{
    protected RabbitMQService $rabbitMQService;
    protected RequestEloquentRepository $repository;

    public function __construct(RabbitMQService $rabbitMQService, RequestEloquentRepository $eloquentRepository)
    {
        $this->rabbitMQService = $rabbitMQService;
        $this->repository = $eloquentRepository;
    }

    /**
     * Create request.
     *
     * This method allows to create a new request.
     * It stores the request data in the repository and sends it to the RabbitMQ service.
     *
     * @OA\Post(
     *     path="/api/request",
     *     summary="Create a new request",
     *     description="This endpoint allows you to create a new request and enqueue it for processing.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data", type="string", example="payload data here"),
     *                 required={"data"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Request created successfully", @OA\JsonContent(
     *         @OA\Property(property="request_id", type="integer", example=1)
     *     )),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent(),
     *     ),
     *     @OA\Response(response="default", description="Unexpected error", @OA\JsonContent(),
     *     )
     * )
     */
    public function create(Request $request)
    {
        $requestId = $this->repository->create('new');
        $this->rabbitMQService->send(['id' => $requestId['id'], 'data' => $request->input('data')]);

        return response()->json(['request_id' => $requestId['id']], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/status/{id}",
     *     tags={"Requests"},
     *     summary="Check request status",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status retrieved successfully"
     *     )
     * )
     */
    public function status($requestId): \Illuminate\Http\JsonResponse
    {
        $request = $this->repository->getById($requestId);

        if (!$request) {
            return response()->json(['error' => 'Request not found'], 404);
        }

        return response()->json(['status' => $request->status]);
    }

    /**
     * Update status.
     *
     * This method updates the status of a request identified by its ID.
     *
     * @OA\Put(
     *     path="/api/update/{id}/{status}",
     *     summary="Update request status",
     *     description="Updates the status of the request identified by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The identifier of the request.",
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="path",
     *         description="The new status of the request.",
     *         required=true,
     *         example="completed"
     *     ),
     *     @OA\Response(response="200", description="Request status updated successfully", @OA\JsonContent(
     *         @OA\Property(property="status", type="string", example="Ok")
     *     )),
     *     @OA\Response(response="404", description="Request not found", @OA\JsonContent(
     *         @OA\Property(property="error", type="string", example="Request not found")
     *     )),
     *     @OA\Response(response="default", description="Unexpected error", @OA\JsonContent())
     * )
     */

    public function update($id, $status): \Illuminate\Http\JsonResponse
    {
        $request = $this->repository->update($id, $status);

        return response()->json(['status' => 'Ok']);
    }
}
