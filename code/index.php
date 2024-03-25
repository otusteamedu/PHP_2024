<?php

declare(strict_types=1);

$string = $_POST['string'] ?? '';

/**
 * Проверки строки на корректность скобок
 *
 * @param $str
 * @return bool
 */
function isBracketsValid($str): bool
{
    $stack = [];

    foreach (str_split($str) as $char) {
        if ($char == '(') {
            $stack[] = $char;
        } elseif ($char == ')') {
            if (empty($stack) || array_pop($stack) != '(') {
                return false;
            }
        }
    }

    return empty($stack);
}

if (!empty($string) && isBracketsValid($string)) {
    header('HTTP/1.1 200 OK');
    echo "Строка корректна.";
} else {
    header('HTTP/1.1 400 Bad Request');
    echo "Строка некорректна.";
}

