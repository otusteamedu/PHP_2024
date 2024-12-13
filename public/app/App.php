<?php

namespace App;

class App
{
    public function run(): void
    {
        $responseHandler = new ResponseHandler();
        $validator = new Validator();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = $_POST['string'] ?? '';

            if (empty($input)) {
                $responseHandler->sendResponse(400, "Bad Request: The input string is empty.");
            }

            if ($validator->isValidParentheses($input)) {
                $responseHandler->sendResponse(200, "OK: The parentheses string is valid.");
            } else {
                $responseHandler->sendResponse(400, "Bad Request: The parentheses string is invalid.");
            }
        } else {
            $responseHandler->sendResponse(405, "Method Not Allowed: Use POST.");
        }
    }
}
