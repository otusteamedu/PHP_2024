<?php

declare(strict_types=1);

// Устанавливаем заголовки для обработки CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("HTTP/1.1");

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из POST-запроса
    $string = isset($_POST['string']) ? $_POST['string'] : '';

    // Проверка на непустоту
    if (empty($string)) {
        http_response_code(400);
        echo json_encode(["message" => "String cannot be empty."]);
        exit;
    }

    // Функция для проверки корректности скобок
    function areBracketsBalanced($str) {
        // Инициализация счетчика
        $count = 0;

        // Проходим по каждому символу в строке
        for ($i = 0; $i < strlen($str); $i++) {
            // Увеличиваем счетчик для открывающей скобки
            if ($str[$i] == '(') {
                $count++;
            }
            // Уменьшаем счетчик для закрывающей скобки
            elseif ($str[$i] == ')') {
                $count--;
            }

            // Если счетчик становится отрицательным, значит закрывающие скобки идут первыми
            if ($count < 0) {
                return false;
            }
        }

        // Счетчик должен вернуться к нулю для сбалансирования
        return $count === 0;
    }

    // Проверка на корректность пары скобок
    if (!areBracketsBalanced($string)) {
        http_response_code(400);
        echo json_encode(["message" => "String is not balanced."]);
    } else {
        http_response_code(200);
        echo json_encode(["message" => "All good!"]);
    }
} else {
    // Если метод запроса не POST
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed."]);
}
