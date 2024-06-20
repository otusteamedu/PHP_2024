<?php declare(strict_types=1);

function checkParentheses(string $string): bool
{
    $chars = str_split($string);

    $stack = [];

    foreach ($chars as $char) {
        if ($char === '(') {
            $stack[] = $char;
        } else if ($char === ')') {
            if (empty($stack)) {
                return false;
            }

            array_pop($stack);
        }
    }

    return empty($stack);
}

header('Content-Type: application/json');

$string = $_REQUEST['string'] ?? null;

try {
    if (empty($string)) {
        throw new Exception('The required input is empty or not provided.', 400);
    }

    if (!is_string($string)) {
        throw new Exception('The provided input is not a valid string.', 400);
    }

    if (!checkParentheses($string)) {
        throw new Exception('Parentheses are invalid.', 400);
    }

    echo 'Parentheses are valid!';
} catch (Exception $exception) {
    http_response_code($exception->getCode());

    echo $exception->getMessage();
}
