<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Classes;

class Request
{
    public function getPath(): array
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = trim($path, '/');

        $params = explode('/', $path);

        return empty($params[0]) ? ['main'] : $params;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}