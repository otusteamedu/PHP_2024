<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    /**
     * Метод формирует json ответ
     *
     * @param array $data
     * @param string $message
     * @param int $status
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function jsonResponse(
        array  $data,
        string $message = '',
        int    $status = Response::HTTP_OK,
        array  $headers = []
    ): JsonResponse
    {
        return new JsonResponse(
            [
                'data' => $data,
                'message' => $message,
            ],
            $status,
            $headers,
            JSON_UNESCAPED_UNICODE
        );
    }
}
