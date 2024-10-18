<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $string = $_POST['string'] ?? '';

    // Проверка на непустоту
    if (empty($string)) {
        http_response_code(400);
        echo "Bad Request: String cannot be empty.";
        exit;
    }

    // Проверка на корректность количества открытых и закрытых скобок
    $openCount = substr_count($string, '(');
    $closeCount = substr_count($string, ')');

    if ($openCount !== $closeCount) {
        http_response_code(400);
        echo "Bad Request: Mismatched parentheses.";
        exit;
    }

    // Если все проверки пройдены
    http_response_code(200);
    echo "OK: The string is valid.";
}
