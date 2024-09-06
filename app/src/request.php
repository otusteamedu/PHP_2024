<?php

declare(strict_types=1);

namespace App\Request;

function isPost(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function post(string $key, $default = null): mixed
{
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }

    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input[$key])) {
        return $input[$key];
    }

    return $default;
}
