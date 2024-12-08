<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Queue;
use App\Jobs\TaskJob;

/**
 * @OA\Info(
 *     title="Rest Api Queue",
 *     version="1.0.0",
 *     description="API для управления задачами"
 * )
 * @OA\Server(
 *     url="http://localhost",
 *     description="Local server"
 * )
 */
class TaskController extends Controller
{
    /**
     * @OA\Post(
     *     path="/tasks",
     *     summary="Создать задачу",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Sample Task")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Задача успешно создана",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="taskId", type="string", example="12345")
     *         )
     *     )
     * )
     */
    public function createTask()
    {
        $taskId = uniqid();

        $result = [
            'id' => $taskId,
            'status' => 'wait',
        ];

        file_put_contents(storage_path("app/tasks/{$taskId}.task"), json_encode($result));

        Queue::push(new TaskJob($taskId));

        return response()->json([
            'task_id' => $taskId
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/tasks/{taskId}",
     *     summary="Получить статус задачи",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         required=true,
     *         description="ID задачи",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о задаче",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="taskId", type="string", example="12345"),
     *             @OA\Property(property="status", type="string", example="processed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Информация о задаче",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Task not found")
     *         )
     *     )
     * )
     */
    public function getTask($taskId)
    {
        $resFile = storage_path("app/tasks/{$taskId}.task");

        if (!file_exists($resFile)) {
            return response()->json([
                'error' => 'Task not found'
            ], 404);
        }

        $jsonRes = file_get_contents($resFile);

        return response($jsonRes, 200, ['Content-Type' => 'application/json']);
    }
}
