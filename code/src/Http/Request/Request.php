<?php

declare(strict_types=1);

namespace Viking311\Analytics\Http\Request;

class Request
{
    /** @var string  */
    private string $body;
    /** @var string */
    private string $method;
    /** @var string  */
    private string $uri;

    public function __construct()
    {
        $this->body = file_get_contents('php://input');
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_METHOD'];
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
}
