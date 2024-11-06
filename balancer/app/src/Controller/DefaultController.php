<?php

namespace App\Controller;

use App\Service\Validator;

class DefaultController
{
    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->prepareResponse(['error' => 'Only POST requests are allowed'], 405);
        }

        $data = $_POST;

        if (empty($data['string'])) {
            return $this->prepareResponse(['error' => 'Parameter "string" is required and cannot be empty'], 400);
        }

        $validationResult = Validator::validateString($data['string']);
        if ($validationResult !== true) {
            return $this->prepareResponse(['error' => $validationResult], 400);
        }

        return $this->prepareResponse([
            'status' => 'success',
            'message' => 'String is valid',
            'data_received' => $data['string']
        ], 200);
    }

    private function prepareResponse(array $response, int $statusCode): array
    {
        return ['body' => $response, 'status_code' => $statusCode];
    }
}