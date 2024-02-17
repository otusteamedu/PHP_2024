<?php

declare(strict_types=1);

namespace Rmulyukov\Hw4;

final readonly class Request
{
    private array $post;

    public function __construct()
    {
        $this->post = $_POST;
    }

    public function get(string $key, string $default = ''): string
    {
        $value = $this->post[$key] ?? null;
        return is_string($value) ? $value : $default;
    }
}
