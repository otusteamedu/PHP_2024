<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw4;

class App
{
    public function run() {
        echo $this->handleRequest();
    }

    private function handleRequest(): string {
        header('Content-Type: application/json; charset=utf-8');

        try {
            BracesValidator::validate($_POST['string'] ?? '');
            $response = ['message' => 'OK'];
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            $response = ['message' => $e->getMessage()];
        }

        return json_encode($response);
    }
}