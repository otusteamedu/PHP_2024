<?php

namespace Ekonyaeva\Otus\App;

use Ekonyaeva\Otus\Services\Validator;

class App
{
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $string = $_POST['string'] ?? '';
            $response = $this->handleRequest($string);
        } else {
            $response = [
                'status' => 405,
                'message' => '405 Method Not Allowed: метод не поддерживается'
            ];
        }

        http_response_code($response['status']);
        echo $response['message'];
    }

    private function handleRequest($string)
    {
        $validator = new Validator();
        return $validator->validate($string);
    }
}