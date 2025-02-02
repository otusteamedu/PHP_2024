<?php

namespace app\Controllers;

use app\Services\ValidationService;

class MainController
{
    private ValidationService $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function handleRequest(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Ошибка: запрос должен быть отправлен методом POST.', 'code' => 400];
        }

        if (!isset($_POST['string'])) {
            return ['success' => false, 'message' => 'Ошибка: параметр "string" отсутствует в запросе.', 'code' => 400];
        }

        $string = $_POST['string'];
        return $this->validationService->validateString($string);
    }
}

?>