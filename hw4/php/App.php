<?php

require_once 'Validation.php';
require_once 'Response.php';

class App
{
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return Response::error(405, "Method Not Allowed");
        }

        $string = $_POST['string'] ?? '';

        // Проверка строки через класс Validation
        $validation = new Validation();
        $validationResult = $validation->validateString($string);

        if ($validationResult !== true) {
            return Response::error(400, $validationResult);
        }

        // Если валидация успешна
        return Response::success("The string is valid.");
    }
}
