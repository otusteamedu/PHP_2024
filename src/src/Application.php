<?php

declare(strict_types=1);

namespace TimurShakirov\Hw4;

use TimurShakirov\Hw4\StackBrackets;
use Exception;

class Application
{
    public function run()
    {
        return $this->request();
    }

    private function request(): string
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!array_key_exists('string', $_POST)) {
                throw new Exception("Not found 'string' param in request");
            }
            if (empty($_POST['string'])) {
                throw new Exception("Empty string");
            }
            $validator = (new StackBrackets($_POST['string']))->check();
            if (!$validator) {
                throw new Exception("The number of open and closed parentheses does not match.");
            }
            $response = [
                'status' => true,
                'message' => 'Success',
            ];
        } catch (Exception $e) {
            http_response_code(400);
            $response = [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }

        return json_encode($response);
    }
}
