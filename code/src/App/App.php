<?php

namespace Ekonyaeva\Otus\App;

use Ekonyaeva\Otus\Services\Validator;

class App
{
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $string = $_POST['string'] ?? '';
            return $this->handleRequest($string);
        }

        return [
            'status' => 405,
            'message' => '405 Method Not Allowed: метод не поддерживается'
        ];
    }

    private function handleRequest($string): array
    {
        $validator = new Validator();
        return $validator->validate($string);
    }
}