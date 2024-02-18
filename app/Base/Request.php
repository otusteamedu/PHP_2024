<?php

declare(strict_types=1);

namespace App\Base;

class Request
{
    private array $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function data(string $key = null): array|string|null
    {
        return match ($_SERVER['REQUEST_METHOD']) {
            'POST' => $this->postData($key),
            default => $this->getData($key)
        };
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    private function getData(string $key = null): string|array|null
    {
        if (!$key) {
            return $_GET;
        }

        return $_GET[$key] ?? null;
    }

    private function postData(string $key = null): string|array|null
    {
        if (!$key) {
            return $_POST;
        }

        return $_POST[$key] ?? null;
    }
}
