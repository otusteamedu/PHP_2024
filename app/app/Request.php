<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

use InvalidArgumentException;

use function is_string;

readonly final class Request
{
    private array $post;

    public function __construct()
    {
        $this->post = $_POST;
    }

    public function getParam(string $key): string
    {
        if (!isset($this->post[$key])) {
            throw new InvalidArgumentException("Key '$key' not set in post params");
        }
        if (!is_string($this->post[$key])) {
            throw new InvalidArgumentException("Param '$key' must be string");
        }
        return $this->post[$key];
    }
}
