<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp\Http\Controllers;

class Controller
{
    /**
     * Метод отдает json в ответ
     *
     * @param array $data
     * @param int $code
     *
     * @return void
     */
    protected function sendJsonResponse(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        $data['hostname'] = $_SERVER['HOSTNAME'];
        $data['session'] = $_SESSION;

        echo json_encode($data);
    }
}
