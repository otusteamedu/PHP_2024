<?php

declare(strict_types=1);

namespace App\Request;

use ArrayObject;

class Request
{
    /** @var ArrayObject */
    private ArrayObject $post;
    /** @var string */
    private string $method;
    /** @var string  */
    private string $uri;

    public function __construct()
    {
        $this->post = new ArrayObject($_POST);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return ArrayObject
     */
    public function getPost(): ArrayObject
    {
        return $this->post;
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
}
