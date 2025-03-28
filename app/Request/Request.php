<?php

declare(strict_types=1);

namespace App\Request;

class Request
{
    protected array $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }
    public function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->request)
            ? $this->request[$key]
            : $default;
    }
}
