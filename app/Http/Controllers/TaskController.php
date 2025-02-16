<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Jobs\TaskJob;

class TaskController extends Controller
{
    /**
     * Метод добавляет задачу в очередь
     * с тестовыми данными
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        // Генерируем случайный id
        $taskId = uniqid();

        // Добавляем файл в storage с id запроса
        file_put_contents(
            storage_path("app/tasks/{$taskId}.task"),
            json_encode([
                'id' => $taskId,
                'status' => 'In progress'
            ])
        );

        // Добавляем задачу в очередь
        Queue::push(new TaskJob($taskId));

        return $this->jsonResponse([
            'task_id' => $taskId
        ], 'Request is being processed!');
    }

    /**
     * Метод получает запрос из очереди
     * по переданному идентификатору
     *
     * @param string $taskId
     *
     * @return JsonResponse|Response
     */
    public function getTask(string $taskId): JsonResponse|Response
    {
        $getFileByTaskId = storage_path("app/tasks/{$taskId}.task");

        if (!file_exists($getFileByTaskId)) {
            return $this->jsonResponse([], 'Task not found!', 404);
        }

        $response = json_decode(file_get_contents($getFileByTaskId), true);

        return $this->jsonResponse($response);
    }
}
