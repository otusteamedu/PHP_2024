<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Http;

class Request
{
    /** @var string */
    private string $method;
    /** @var string */
    private string $uri;
    /** @var array */
    private array $post;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $this->uri = $uri['path'];
        $this->post = $_POST;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array<string, mixed>
     */
    public function getPost(): array
    {
        return $this->post;
    }
}
