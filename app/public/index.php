<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    throw new Exception('Method Not Allowed');
}

$post = function (string $key): mixed {
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }

    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input[$key])) {
        return $input[$key];
    }

    return null;
};

$string = $post('string');

if (empty($string)) {
    http_response_code(400);

    throw new Exception('The [string] cannot be empty');
}

$isStringValid = function (string $string): bool {
    $stack = [];

    $opened = '(';
    $closed = ')';

    foreach (str_split($string) as $char) {
        if ($char === $opened) {
            $stack[] = $char;
        } else if ($char === $closed && end($stack) === $opened) {
            array_pop($stack);
        } else {
            return false;
        }
    }

    return count($stack) === 0;
};

if ($isStringValid($string)) {
    http_response_code(200);

    echo 'OK';
} else {
    http_response_code(400);

    throw new Exception('The [string] is not a valid');
}
