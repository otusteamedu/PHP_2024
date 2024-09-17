<?php

declare(strict_types=1);

namespace FTursunboy\PhpWebservers;

class Application
{
    public function execute(): string
    {
        return $this->processRequest();
    }

    private function processRequest(): string
    {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $inputValidator = new Validator();
            $inputValidator->checkData($_POST['payload'] ?? '');
            $result = [
                'error' => false,
                'message' => 'Valid data received',
            ];
        } catch (\InvalidArgumentException $exception) {
            http_response_code(400);
            $result = [
                'error' => true,
                'message' => $exception->getMessage(),
            ];
        }

        return json_encode($result);
    }
}
