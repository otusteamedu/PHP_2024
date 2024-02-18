<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Validator;

class Request
{
    /**
     * @var mixed|string
     */
    private string $method;
    private array $post;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->post = $_POST;
    }

    public function isPostRequest(): bool
    {
        return 'POST' === $this->method;
    }

    public function getPostValue(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }
}
