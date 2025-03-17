<?php
require_once __DIR__ . '/../models/StatementRequest.php';

class StatementController {
    private $requestModel;

    public function __construct() {
        $this->requestModel = new StatementRequest();
    }

    public function showForm() {
        require_once __DIR__ . '/../views/statement/form.php';
    }

    public function processForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'email' => $_POST['email']
            ];

            if ($this->requestModel->validate($data)) {
                $this->requestModel->queueRequest($data);
                $message = "Запрос на генерацию выписки принят в обработку. Результат будет отправлен на {$data['email']}";
                require_once __DIR__ . '/../views/statement/success.php';
            } else {
                $error = "Пожалуйста, заполните все поля корректно";
                require_once __DIR__ . '/../views/statement/form.php';
            }
        } else {
            $this->showForm();
        }
    }
}