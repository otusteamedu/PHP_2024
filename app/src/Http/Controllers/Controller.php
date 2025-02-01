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
     * @return string
     */
    protected function sendJsonResponse(array $data, int $code = 200): string
    {
        header_remove();
        http_response_code($code);
        header('Content-Type: application/json');
        header('Status: ' . $code);
        $data['hostname'] = $_SERVER['HOSTNAME'];
        $data['session'] = $_SESSION;

        return json_encode($data);
    }
}
