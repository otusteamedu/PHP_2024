<?php

declare(strict_types=1);

namespace Request;

function getMethod(): string
{
    return $_SERVER['REQUEST_METHOD'] ?? 'GET';
}

function isPost(): bool
{
    return getMethod() === 'POST';
}

function post(string $name, mixed $default = null): mixed
{
    return filter_input(INPUT_POST, $name) ?? $default;
}
