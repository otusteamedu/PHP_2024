<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCase\AddLead\AddLeadRequest;
use App\Application\UseCase\AddLead\AddLeadUseCase;
use App\Application\UseCase\GetLeadResult\GetLeadResultUseCase;
use App\Application\UseCase\GetLeadStatus\GetLeadStatusUseCase;
use App\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @param AddLeadUseCase $addLeadUseCase
     * @param GetLeadResultUseCase $getLeadResultUseCase
     * @param GetLeadStatusUseCase $getLeadStatusUseCase
     */
    public function __construct(
        public readonly AddLeadUseCase       $addLeadUseCase,
        public readonly GetLeadResultUseCase $getLeadResultUseCase,
        public readonly GetLeadStatusUseCase $getLeadStatusUseCase,
    ) {
    }

    /**
     * @OA\Post (
     *     path="/leads/",
     *     tags={"Leads"},
     *     description="Создание заявки",
     *     summary="Создание заявки",
     *     security={{"token": {}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="userName", type="string", example="Иванов Петр"),
     *             @OA\Property(property="email", type="string", description="Email", example="test@testemail.ru" ),
     *             @OA\Property(property="body", type="string", example="Какая-то информация по заявке"),
     *         )
     *     ),
     *     @OA\Response (response="201", description="Заявка успешно создана",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="int"),
     *         )
     *     ),
     *     @OA\Response (response="400", description="Ошибка создания заявки",
     *         @OA\JsonContent(
     *              @OA\Property(property="error", type="string"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addLead(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $addLeadRequest = new AddLeadRequest(
                $data['userName'],
                $data['email'],
                $data['body'],
            );

            return response()->json(($this->addLeadUseCase)($addLeadRequest), 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Ошибка создания заявки ' . $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get (
     *     path="/leads/{leadId}/status",
     *     tags={"Leads"},
     *     description="Получить статус заявки",
     *     summary="Получить статус заявки",
     *     security={{"token": {}}},
     *     @OA\Parameter (name="leadId", in="path", description="Номер заявки"),
     *     @OA\Response (response="200", description="Статус заявки",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string"),
     *         )
     *     ),
     *     @OA\Response (response="404", description="Заявка не найдена",
     *         @OA\JsonContent(
     *              @OA\Property(property="error", type="string"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param int $leadId
     * @return JsonResponse
     */
    public function getLeadStatus(Request $request, int $leadId): JsonResponse
    {
        try {
            return response()->json(($this->getLeadStatusUseCase)($leadId));
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Get (
     *     path="/leads/{leadId}/result",
     *     tags={"Leads"},
     *     description="Получить результат выполнения заявки",
     *     summary="Получить результат выполнения заявки",
     *     security={{"token": {}}},
     *     @OA\Parameter (name="leadId", in="path", description="Номер заявки"),
     *     @OA\Response (response="200", description="Результат выполнения заявки",
     *         @OA\JsonContent(
     *              @OA\Property (property="result", type="object",
     *                  @OA\Property (property="sum", type="integer"),
     *                  @OA\Property (property="status", type="string"),
     *                  @OA\Property (property="message", type="string")
     *              ),
     *         )
     *     ),
     *     @OA\Response (response="404", description="Заявка не найдена",
     *         @OA\JsonContent(
     *              @OA\Property(property="error", type="string"),
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @param int $leadId
     * @return JsonResponse
     */
    public function getLeadResult(Request $request, int $leadId): JsonResponse
    {
        try {
            return response()->json([
                                        'result' => json_decode(($this->getLeadResultUseCase)($leadId)->result)
                                    ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
