<?php

namespace Den\Hw5\Http;

class Request
{
    public function __construct(
        private readonly array $params,
        private readonly array $postData,
        private readonly array $cookies,
        private readonly array $files,
        private readonly array $server
    ) {
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getData(): array
    {
        return $this->postData ?: [];
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getServer(): array
    {
        return $this->server;
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }
}
