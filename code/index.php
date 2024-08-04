<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $string = $_POST['string'] ?? '';

    if (empty($string)) {
        http_response_code(400);
        echo "400 Bad Request: строка пуста";
        exit();
    }

    $stack = [];
    foreach (str_split($string) as $char) {
        if ($char === '(') {
            array_push($stack, $char);
        } elseif ($char === ')') {
            if (empty($stack)) {
                http_response_code(400);
                echo "400 Bad Request: некорректное количество скобок";
                exit();
            }
            array_pop($stack);
        }
    }

    if (!empty($stack)) {
        http_response_code(400);
        echo "400 Bad Request: некорректное количество скобок";
        exit();
    }

    http_response_code(200);
    echo "200 OK: строка корректна";
}
