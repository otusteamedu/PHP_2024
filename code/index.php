<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo badResponse('Неверный метод, используйте POST!');
} else {
    $str = $_POST['string'] ?? '';
    $str = normalize($str); // удаляем все символы, кроме скобок

    if (empty($str)) {
        echo badResponse('Параметр string пустой или не содержит скобок!');
    } elseif (!isBracketsValid($str)) {
        echo badResponse('Скобки расставлены неверно!');
    } else {
        echo okResponse('Скобки расставлены верно!');
    }
}

/**
 * Удаляет все символы из строки, кроме скобок
 *
 * @param string $str
 * @return string
 */
function normalize(string $str): string
{
    return preg_replace('/[^()]/', '', $str);
}

/**
 * Проверяет расстановку скобок в строке на валидность
 * @param string $bracketString
 * @return bool
 */
function isBracketsValid(string $bracketString): bool
{
    $stack = [];
    foreach (str_split($bracketString) as $bracket) {
        if ($bracket === '(') {
            array_push($stack, $bracket);
        } elseif ($bracket === ')') {
            if (is_null(array_pop($stack))) {
                return false;
            }
        }
    }

    return count($stack) === 0;
}

/**
 * Возвращает неуспешный ответ
 *
 * @param string $message
 * @return string
 */
function badResponse(string $message = 'Все плохо!'): string
{
    http_response_code(400);
    return $message;
}

/**
 * Возвращает успешный ответ
 *
 * @param string $message
 * @return string
 */
function okResponse(string $message = 'Все хорошо!'): string
{
    http_response_code(200);
    return $message;
}
