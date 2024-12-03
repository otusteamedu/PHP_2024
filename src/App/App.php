<?php

declare(strict_types=1);

namespace App;

class App
{
    public function run(): void
    {
        $data = $this->getPostParams();

        if (empty($data) || !isset($data['string'])) {
            $this->response([
                'status' => 'ERROR',
                'message' => 'Ожидается POST запрос с параметром string',
                'code' => 400
            ]);

            return;
        }

        $checkerBracket = new CheckerBracket();

        try {
            $isChecked = $checkerBracket->validateBrackets($data['string']);
            $result = [
                'status' => 'OK',
                'message' => 'Все хорошо',
                'code' => 200
            ];
        } catch (\Exception $e) {
            $result = [
                'status' => 'ERROR',
                'message' => $e->getMessage(),
                'code' => 400
            ];
        }

        $this->response($result);
    }

    public function getPostParams(): array
    {
        $postData = file_get_contents('php://input');
        return json_decode($postData, true);
    }

    private function response($result): void
    {
        http_response_code($result['code']);
        header('Content-type: application/json');

        $count = Counter::addCount();

        echo json_encode([
            'status' => $result['status'],
            'message' => $result['message'],
            'code' => $result['code'],
            'count_view' => $count,
        ]);

    }
}