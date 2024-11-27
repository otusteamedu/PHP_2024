<?php

namespace App;

use App\MailValidationService;

class App
{
    /**
     * @throws \Exception
     */
    public static function run(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $requestBody = $requestParam = [];

        $mailValidationService = new MailValidationService();

        if ($requestMethod === 'POST') {
            $requestBody = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        if ($requestMethod === 'GET') {
            $requestBody = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        if (!RequestValidationClass::validateRequestBody($requestBody, $mailValidationService::MAILS_PARAM_NAME)) {
            echo 'Unprocessable Entity';
            return;
        }

        // Строка запроса
        $requestParam = $requestBody[$mailValidationService::MAILS_PARAM_NAME] ?? [];

        if ($mailValidationService->validate($requestParam)) {
            echo 'Email is valid';
        } else {
            echo 'Email is not valid';
        }

        return;
    }
}
