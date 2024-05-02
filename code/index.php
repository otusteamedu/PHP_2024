<?php

declare(strict_types=1);

$string = $_POST['string'] ?? '';
$bracketsCounter = 0;

foreach (str_split($string) as $char) {
    if ($char == '(') {
        $bracketsCounter++;
    } elseif ($char == ')') {
        $bracketsCounter--;
    }
}

if (!empty($string) && $bracketsCounter === 0) {
    http_response_code(200);
    header('Content-Type: text/plain; charset=utf-8');
    return "Строка корректна.";
} else {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    return "Строка некорректна.";
}
