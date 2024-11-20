<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    protected array $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function get(string $key, $default = null)
    {
        return $this->request[$key] ?? $default;
    }
}
