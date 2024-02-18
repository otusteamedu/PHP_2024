<?php

namespace Ahar\Hw4;

class Request
{
    public function post(string $key, mixed $default = '')
    {
        return $_POST[$key] ?? $default;
    }
}
