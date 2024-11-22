<?php

namespace App;

class App
{
    public static function run(): void
    {
        // start session
        session_start();

        // Метод запроса
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $responseCode = 422;
        $responseMessage = 'Unprocessable Entity';

        if ($requestMethod === 'POST') {
            $requestBody = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!ValidationClass::validateRequestBody($requestBody)) {
                ResponseClass::sendResponse($responseMessage, $responseCode);
                return;
            }

            // Строка запроса
            $requestString = $requestBody['string'];

            if (!ValidationClass::validateRequestString($requestString)) {
                $responseMessage = 'Brackets count mismatch';
                ResponseClass::sendResponse($responseMessage, $responseCode);
                return;
            }

            $responseCode = 200;
            $responseMessage = 'OK';
        }

        ResponseClass::sendResponse($responseMessage, $responseCode);
    }
}
