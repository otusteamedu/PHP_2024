<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp\Http\Requests;

class Request
{
    /** @var string */
    public string $path;

    /** @var string */
    public string $method;

    /** @var array */
    public array $params;

    public function __construct()
    {
        $this->path = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = [
            'get' => $_GET,
            'post' => $_POST,
        ];
    }
}
