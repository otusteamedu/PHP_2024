<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['string'] ?? '';

    if (empty($input)) {
        http_response_code(400);
        echo "Bad Request: The input string is empty.";
        exit;
    }

    if (isValidParentheses($input)) {
        http_response_code(200);
        echo "OK: The parentheses string is valid.";
    } else {
        http_response_code(400);
        echo "Bad Request: The parentheses string is invalid.";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed: Use POST.";
}

function isValidParentheses(string $input): bool
{
    $stack = [];
    $length = strlen($input);

    for ($i = 0; $i < $length; $i++) {
        if ($input[$i] === '(') {
            array_push($stack, '(');
        } elseif ($input[$i] === ')') {
            if (empty($stack)) {
                return false;
            }
            array_pop($stack);
        } else {
            return false;
        }
    }

    return empty($stack);
}
