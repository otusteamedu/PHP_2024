<?php

namespace App;

class App
{
    public function validateString(string $input): bool
    {
        $balance = 0;
        for ($i = 0; $i < strlen($input); $i++) {
            if ($input[$i] === '(') {
                $balance++;
            } elseif ($input[$i] === ')') {
                $balance--;
                if ($balance < 0) {
                    return false;
                }
            }
        }
        return $balance === 0;
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method Not Allowed";
            return;
        }

        $input = $_POST['string'] ?? '';

        if (empty($input)) {
            http_response_code(400);
            echo "Bad Request: string is empty";
            return;
        }

        if ($this->validateString($input)) {
            http_response_code(200);
            echo "OK: string is valid";
        } else {
            http_response_code(400);
            echo "Bad Request: string is invalid";
        }
    }
}