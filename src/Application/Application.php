<?php

declare(strict_types=1);

namespace PavelMiasnov\Hw4;

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
            $validator = new Validator();
            $validator->validate($_POST['string'] ?? '');
            $response = [
                'error' => false,
                'message' => 'Correct',
            ];
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            $response = [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        return json_encode($response);
    }
}
