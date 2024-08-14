<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Http\Request;

class Request
{
    /** @var string  */
    private string $body;
    /** @var string */
    private string $method;
    /** @var string  */
    private string $uri;
    /** @var array */
    private array $query;

    public function __construct()
    {
        $this->body = file_get_contents('php://input');
        $this->method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $this->uri = $uri['path'];
        $this->query = $_GET;
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
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        return $this->query;
    }
}
