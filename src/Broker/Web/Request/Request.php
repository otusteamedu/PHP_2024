<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Web\Request;

class Request
{
    public function __construct(
        private string $requestMethod,
        private array $get,
        private array $post
    ) {
    }

    public function isPost(): bool
    {
        return $this->requestMethod === 'post';
    }

    public function isGet(): bool
    {
        return $this->requestMethod === 'get';
    }

    public function get(string $name, mixed $defaultValue = null)
    {
        return $this->get[$name] ?? $defaultValue;
    }

    public function post(string $name, mixed $defaultValue = null)
    {
        return $this->post[$name] ?? $defaultValue;
    }
}
