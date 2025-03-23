<?php

session_start();

// Устанавливаем корректные заголовки для ответа
header('Content-Type: text/plain');

// Проверяем, что запрос POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Метод не поддерживается
    echo "Method Not Allowed";
    exit;
}

// Получаем строку string из POST-запроса
$string = $_POST['string'] ?? null;

// 1.1. Проверка на непустоту
if (empty($string)) {
    http_response_code(400); // Некорректный запрос
    echo "Ошибка: строка пуста";
    exit;
}

// 1.2. Проверка корректности открытых/закрытых скобок
function isValidParentheses(string $str): bool
{
    $balance = 0;

    for ($i = 0, $len = strlen($str); $i < $len; $i++) {
        if ($str[$i] === '(') {
            $balance++;
        } elseif ($str[$i] === ')') {
            $balance--;
        }

        // Если на каком-то этапе баланс < 0, значит, скобки некорректны
        if ($balance < 0) {
            return false;
        }
    }

    // Строка корректна, если баланс в конце = 0
    return $balance === 0;
}

if (!isValidParentheses($string)) {
    http_response_code(400); // Некорректный запрос
    echo "Ошибка: некорректный формат строки";
    exit;
}

// Если все проверки пройдены
http_response_code(200); // Всё хорошо
echo "Все хорошо: строка корректна.";
